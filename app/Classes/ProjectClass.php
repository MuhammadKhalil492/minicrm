<?php
namespace App\Classes;

use App\Models\Project;

class ProjectClass
{
    private $model;

    public function __construct()
    {
        $this->model = new Project();
    }

    /**
     * This function retrieves all user records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Builder A query builder instance for the User model.
     *
     * @throws \Exception If any error occurs during the database query.
     */
    public function getAllPorjectList()
    {
        $query = $this->model->query();
        return $query;
    }

    public function saveProject($fields, $project_id = null)
    {
        if ($project_id) {
            $project = $this->model->find($project_id);
        } else {
            $project = new $this->model;
        }
        $project->title = $fields['title'];
        $project->status = $fields['status'];
        $project->description = $fields['description'];
        $project->deadline_at = $fields['deadline_at'];
        $project->user_id = $fields['user_id'];
        $project->client_id = $fields['client_id'];
        $project->save();
        return $project;
    }

    public function saveProjectUsers($project,$userIds){
        // dd('ss');
        $user_ids_array = [];
        if (is_array($userIds)) {
            foreach ($userIds as $userID) {
                if (!empty($userID)) {
                    $user_ids_array[] = $userID;
                }
            }
        } elseif (!empty($userIds)) {
            $user_ids_array[] = $userIds;
        }
        if (!empty($user_ids_array)) {
            $project->users()->sync($user_ids_array);
        } else {
            $project->users()->detach();
        }
        return true;
    }
}
