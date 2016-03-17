<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\ResetForm;
use App\Form\PasswordForm;

use Cake\I18n\Time;
use Cake\Mailer\MailerAwareTrait;
// use Cake\Utility\Hash;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    use MailerAwareTrait;

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles', 'Scoutgroups']
        ];
        $this->paginate['conditions'] = array(
            'scoutgroup_id' => $this->Auth->user('scoutgroup_id')
        );
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Scoutgroups','Invoices.Applications'
            ,'Applications.Scoutgroups','Applications.Events'
            ,'Attendees.Scoutgroups' ]
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    //use MailerAwareTrait;

    /*public function register()
    {
        $user = $this->Users->newEntity($this->request->data);

        $usrData = ['section' => 'Cubs', 'authrole' => 'user'];
        $user = $this->Users->patchEntity($user, $usrData);

        if ($this->Users->save($user)) {
            $this->Flash->success(__('You have sucesfully registered!'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        } else {
            $this->Flash->error(__('The user could not be registered. There may be an error. Please, try again.'));
        }

        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $scoutgroups = $this->Users->Scoutgroups->find('list', ['limit' => 200])->order(['district_id' => 'ASC']);
        $this->set(compact('user', 'roles', 'scoutgroups'));
        $this->set('_serialize', ['user']);
    }*/

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);

            $upperUser = ['firstname' => ucwords(strtolower($user->firstname))
                ,'lastname' => ucwords(strtolower($user->lastname))
                ,'address_1' => ucwords(strtolower($user->address_1))
                ,'address_2' => ucwords(strtolower($user->address_2))
                ,'city' => ucwords(strtolower($user->city))
                ,'county' => ucwords(strtolower($user->county))
                ,'postcode' => strtoupper($user->postcode)
                ,'section' => ucwords(strtolower($user->section))];

            $user = $this->Users->patchEntity($user, $upperUser);
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $scoutgroups = $this->Users->Scoutgroups->find('list', 
            [
                'keyField' => 'id',
                'valueField' => 'scoutgroup',
                'groupField' => 'district.district'
            ])
            ->contain(['Districts']);
        $this->set(compact('user', 'roles', 'scoutgroups'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function login($eventId = null)
    {
        // Set the layout.
        $this->viewBuilder()->layout('outside');

        $session = $this->request->session();

        if ($session->check('Reset.lgTries')) {
            $tries = $session->read('Reset.lgTries');
        }

        if (!isset($tries)) {
            $tries = 0;
        }

        if (isset($tries) && $tries < 11) {

            if ($this->request->is('post')) {
                $user = $this->Auth->identify();
                if ($user) {
                    $this->Auth->setUser($user);
                    if (isset($eventId) && $eventId >= 0) {
                        $session->delete('Reset.lgTries');
                        $session->delete('Reset.rsTries');
                        return $this->redirect(['prefix' => false, 'controller' => 'Applications', 'action' => 'book',  $eventId]);
                    } else {
                        $session->delete('Reset.lgTries');
                        $session->delete('Reset.rsTries');
                        return $this->redirect(['prefix' => false, 'controller' => 'Landing', 'action' => 'user_home']);
                    }  
                }
                $tries = $tries + 1;
                $this->Flash->error('Your username or password is incorrect. Please try again.');
                $session->write('Reset.lgTries', $tries);                
            }

            $this->set(compact('eventId'));
        } else {
            $this->Flash->error('You have failed entry too many times. Please try again later.');
            return $this->redirect(['prefix' => false, 'controller' => 'Users', 'action' => 'reset']);     
        }


        
    }

    public function reset()
    {
        $this->viewBuilder()->layout('outside');

        $resForm = new ResetForm();
        $sets = TableRegistry::get('Settings');

        $scoutgroups = $this->Users->Scoutgroups->find('list', 
            [
                'keyField' => 'id',
                'valueField' => 'scoutgroup',
                'groupField' => 'district.district'
            ])
            ->contain(['Districts']);
        $session = $this->request->session();

        $this->set(compact('scoutgroups','resForm'));

        if ($this->request->is('post')) {

            if ($session->check('Reset.rsTries')) {
                $tries = $session->read('Reset.rsTries');
            }

            if (!isset($tries)) {
                $tries = 0;
            }

            if (isset($tries) && $tries < 6) {
                // Extract Form Info
                $fmGroup = $this->request->data['scoutgroup'];
                $fmEmail = $this->request->data['email'];

                $found = $this->Users->find('all')
                    ->where(['email' => $fmEmail, 'scoutgroup_id' => $fmGroup]);

                $count = $found->count('*');
                $user = $found->first();

                $tries = $tries + 1;
                $session->write('Reset.rsTries', $tries);

                if ($count == 1) {
                    // Success in Resetting Triggering Reset - Bouncing to Reset.
                    $session->delete('Reset.lgTries');
                    $session->delete('Reset.rsTries');

                    $user = $this->Users->get($user->id);

                    $now = Time::now();

                    $rMax = $sets->get(16)->text;
                    $rMin = $sets->get(17)->text;

                    $random = rand($rMin,$rMax);

                    $string = 'Reset Success' . ( $user->id * $now->day ) . $random . $now->year . $now->month;

                    $token = Security::hash($string);

                    $newToken = ['reset' => $token];

                    $user = $this->Users->patchEntity($user, $newToken);

                    if ($this->Users->save($user)) {

                        $this->getMailer('User')->send('passres', [$user, $random]);

                    /*$deleteEnt = [
                        'Entity Id' => $notification->id,
                        'Controller' => 'Notifications',
                        'Action' => 'Delete',
                        'User Id' => $this->Auth->user('id'),
                        'Creation Date' => $notification->created,
                        'Modified' => $notification->read_date,
                        'Notification' => [
                            'Type' => $notification->notificationtype_id,
                            'Ref Id' => $notification->link_id,
                            'Action' => $notification->link_action,
                            'Controller' => $notification->link_controller,
                            'Source' => $notification->notification_source,
                            'Header' => $notification->notification_header
                            ]
                        ]
                    
                    $jsonWelcome = json_encode($welcomeData);
                    $api_key = $sets->get(13)->text;
                    $projectId = $sets->get(14)->text;
                    $eventType = 'UserWelcome';
                    
                    $keenURL = 'https://api.keen.io/3.0/projects/' . $projectId . '/events/' . $eventType . '?api_key=' . $api_key;
                    
                    $http = new Client();
                    $response = $http->post(
                      $keenURL,
                      $jsonWelcome,
                      ['type' => 'json']
                    );*/



                        return $this->redirect(['prefix' => false, 'controller' => 'Landing', 'action' => 'welcome']);
                    } else {
                        $this->Flash->error(__('The user could not be saved. Please, try again.'));
                    }
                } else {
                    $this->Flash->error('This user was not found in the system.');
                }
            } else {
                $this->Flash->error('You have failed entry too many times. Please try again later.');
                return $this->redirect(['prefix' => false, 'controller' => 'Landing', 'action' => 'welcome']);
            }
        }
    }

    public function token($userid = null, $decryptor = null) {

        $resettor = $this->Users->get($userid);

        $cipher = $resettor->reset;

        $now = Time::now();

        $string = 'Reset Success' . ( $resettor->id * $now->day ) . $decryptor . $now->year . $now->month;

        $test = Security::hash($string);

        if ($cipher == $test) {

            $PasswordForm = new PasswordForm();
            $this->set(compact('PasswordForm'));

            if ($this->request->is('post')) {

                $fmPassword = $this->request->data['newpw'];
                $fmConfirm = $this->request->data['confirm'];

                if ($fmConfirm == $fmPassword) {

                    $fmPostcode = $this->request->data['postcode'];
                    $fmPostcode = str_replace(" ","",strtoupper($fmPostcode));

                    $usPostcode = $resettor->postcode;
                    $usPostcode = str_replace(" ","",strtoupper($usPostcode));

                    if ($usPostcode == $fmPostcode) {

                        $newPw = ['password' => $fmPassword
                            ,'reset' => 'No Longer Active'];

                        $resettor = $this->Users->patchEntity($resettor, $newPw);

                        if ($this->Users->save($resettor)) {

                            return $this->redirect(['prefix' => false, 'controller' => 'Users', 'action' => 'login']);
                        } else {
                            $this->Flash->error(__('The user could not be saved. Please, try again.'));
                        }
                    } else {
                        $this->Flash->error(__('The user could not be saved. Please, try again.'));
                    }
                } else {
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->Flash->success(__('The user has been saved.'));
            return $this->redirect(['prefix' => false, 'controller' => 'Landing', 'action' => 'welcome']);
        }

    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        $this->Auth->allow(['register']);
        $this->Auth->allow(['login']);
        $this->Auth->allow(['reset']);
        $this->Auth->allow(['token']);
    }
    
    
    public function isAuthorized($user)
    {
        // All registered users can add articles
        if (in_array($this->request->action, ['logout'])) {
            return true;
        }

        // The owner of an application can edit and delete it
        if (in_array($this->request->action, ['view', 'edit'])) {
            $editingId = (int)$this->request->params['pass'][0];
            if ($editingId == $user['id']) {
                return true;
            } else {
                return false;
            }
        }

        return parent::isAuthorized($user);
    }
}
