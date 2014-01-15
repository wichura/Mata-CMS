<?php 


class WelcomeController extends BaseAuthorizedController {

	public function getModel() {
		return null;
	}

	public function actionIndex() {
		echo "Welcome to MATA CMS";
	}
}