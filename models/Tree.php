<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27.02.2018
 * Time: 22:19
 */

namespace app\models;

use stdClass;


class Tree
{
    public $groupstree;
    public $objectstree;
    public $properties;
    public $object;

    //получение директорий групп объектов для построения дерева
    public function getGroupsTree()
    {
        $this->groupstree = file_get_contents("http://195.93.229.66:4242/main?func=readdicts&dicts=objgroupstree&uid=1cdea3c3-957d-4789-afd9-2cbc18a5a1f7&out=json");
        if ($this->groupstree) {
            $this->groupstree = str_replace('childs', 'children', gzdecode($this->groupstree));
            $this->groupstree = str_replace('name', 'text', $this->groupstree);
            $this->groupstree = json_decode($this->groupstree);
            $this->groupstree = $this->groupstree->objgroupstree;
        } else {
            die();
        }
        return $this->groupstree;
    }

    //получение всех мобильных объектов
    public function getObjectsTree()
    {
        $this->objectstree = file_get_contents("http://195.93.229.66:4242/main?func=readdicts&dicts=objects&uid=1cdea3c3-957d-4789-afd9-2cbc18a5a1f7&out=json");
        if ($this->objectstree){
            $this->objectstree = str_replace('childs', 'children', gzdecode($this->objectstree));
            $this->objectstree = str_replace('name', 'text', $this->objectstree);
            $this->objectstree = json_decode($this->objectstree);
            $this->objectstree = $this->objectstree->objects;
        }  else {
            die();
        }
        return $this->objectstree;
    }

    //построение дерева и группировка мобильных объектов согласно групп в JSON
    public function getTree()
    {
        $this->getGroupsTree();
        $this->getObjectsTree();

        foreach($this->groupstree as $group)
        {
            for ($i = 0; $i < count($group->children); $i++){
                foreach ($this->objectstree as $object){
                    if (in_array($group->children[$i]->id, $object->groups)){
                        $ob = new stdClass();
                        $ob->id = $object->id;
                        $ob->text = $object->text;
                        $group->children[$i]->children[] = $ob;
                    }
                }
            }
        }
        return json_encode($this->groupstree, JSON_UNESCAPED_UNICODE);
    }

    //получение всех свойств мобильного объекта в JSON
    public function getProperties($id)
    {
        $this->properties = file_get_contents('http://195.93.229.66:4242/main?func=objectproperties&objects=' . $id . '&uid=1cdea3c3-957d-4789-afd9-2cbc18a5a1f7&out=json');
        $this->properties = gzdecode($this->properties);

        return json_encode($this->properties, JSON_UNESCAPED_UNICODE);
    }

    //получение навигационных и топливных данных мобильного объекта
    public function getObject($id)
    {
        $this->object = file_get_contents('http://195.93.229.66:4242/main?func=state&objects=' . $id . '&fuel&uid=1cdea3c3-957d-4789-afd9-2cbc18a5a1f7&out=json');
        $this->object = gzdecode($this->object);
        $this->object = json_decode($this->object);

        return $this->object;
    }

}