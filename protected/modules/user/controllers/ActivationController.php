<?php

class ActivationController extends Controller
{
	public $defaultAction = 'activation';

	
	/**
	 * Activation user account
	 */
	public function actionActivation () {
		$email = $_GET['email'];
		$activkey = $_GET['activkey'];
		if ($email&&$activkey) {
			$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
			if (isset($find)&&$find->status) {
			    $this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("You account is active.")));
			} elseif(isset($find->activkey) && ($find->activkey==$activkey)) {
				$find->activkey = UserModule::encrypting(microtime());
				$find->status = 1;
				$find->save();
				if ($find->save()) {
					$userProfile = Profile::model()->findByPk($find->id);
					$userData = array(
						'id' => $find->id,
						'email' => $find->email,
						'first_name' => $userProfile->first_name,
						'last_name' => $userProfile->last_name,
						);

					 ini_set("soap.wsdl_cache_enabled", "0");
					$temp=new SoapClient('http://localhost/buglist/index.php?r=stock/quote', array('exceptions' => true, 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' => true));
					$temp->addClient($userData);
				}
			    $this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("You account is activated.")));
			} else {
			    $this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("Incorrect activation URL.")));
			}
		} else {
			$this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("Incorrect activation URL.")));
		}
	}

}