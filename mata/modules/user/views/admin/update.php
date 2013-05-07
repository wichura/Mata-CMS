<h1><?php echo  UserModule::t('Update')." ". $profile->FirstName . " " . $profile->LastName; ?></h1>

<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile, 'allProjectsAvailableToTheUser' => $allProjectsAvailableToTheUser, 
            'activeProjectsForUser' => $activeProjectsForUser));
?>