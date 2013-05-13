<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProjectSelector
 *
 * @author wichura
 */
class ProjectSelector extends BaseWidget {

    public $projects;
    public $activeProjects;
    private $activeProjectIds = array();

    public function init() {

        if ($this->projects == NULL)
            $this->projects = Project::model()->findAll(array(
                "order" => "Name ASC"
            ));

        if ($this->activeProjects != null) {

            foreach ($this->activeProjects as $project) {
                array_push($this->activeProjectIds, $project->Id);
            }
        }
    }

    public function run() {
        $this->renderDefaultView(__FILE__, array(
            "activeProjectIds" => $this->activeProjectIds
                ), "project.widgets");
    }

}

?>
