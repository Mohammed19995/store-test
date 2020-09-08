<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 04/08/19
 * Time: 10:08 ص
 */

namespace App\Traits\Controller;

trait ExecuteOptionsTrait
{


    public function options() {
        return [
            ['id' => 1 , 'name' => trans('admin.change_status_to_active')],
            ['id' => 2 , 'name' => trans('admin.change_status_to_deactive')],
        ];
    }
    public function deleteOption() {
        return [['id' => 3 , 'name' => trans('admin.delete')]];
    }

    public function getOptions() {
        return \GuzzleHttp\json_encode($this->options());
    }
    public function getOptionsWithDelete() {

        return \GuzzleHttp\json_encode(array_merge($this->options() , $this->deleteOption()));
    }
}