<?php
/* This file has been auto-generated. Do not edit this file directly. */

abstract class Sabai_Addon_Voting_Model_Base_Vote extends SabaiFramework_Model_Entity
{
    public function __construct(SabaiFramework_Model $model)
    {
        parent::__construct('Vote', $model);
        $this->_vars = array('vote_entity_type' => null, 'vote_bundle_id' => 0, 'vote_entity_id' => 0, 'vote_value' => 0, 'vote_tag' => null, 'vote_name' => null, 'vote_comment' => null, 'vote_reference_id' => 0, 'vote_ip' => null, 'vote_id' => 0, 'vote_created' => 0, 'vote_updated' => 0, 'vote_user_id' => 0);
    }

    public function __clone()
    {
        $this->_vars = array('vote_id' => 0, 'vote_created' => 0, 'vote_updated' => 0) + $this->_vars;
    }

    public function __toString()
    {
        return $this->__get('name');
    }

    protected function _assignUser($user, $markDirty = true)
    {
        $this->_setVar('vote_user_id', $user->id, $markDirty);
    }

    protected function _fetchUser()
    {
        if (!isset($this->_objects['User'])) {
            $this->_objects['User'] = $this->_model->UserIdentity($this->_vars['vote_user_id']);
        }

        return $this->_objects['User'];
    }

    public function isOwnedBy($user)
    {
        return $this->user_id && $this->user_id == $user->id;
    }

    public function __get($name)
    {
        if ($name === 'entity_type')
            return $this->_vars['vote_entity_type'];
        elseif ($name === 'bundle_id')
            return $this->_vars['vote_bundle_id'];
        elseif ($name === 'entity_id')
            return $this->_vars['vote_entity_id'];
        elseif ($name === 'value')
            return $this->_vars['vote_value'];
        elseif ($name === 'tag')
            return $this->_vars['vote_tag'];
        elseif ($name === 'name')
            return $this->_vars['vote_name'];
        elseif ($name === 'comment')
            return $this->_vars['vote_comment'];
        elseif ($name === 'reference_id')
            return $this->_vars['vote_reference_id'];
        elseif ($name === 'ip')
            return $this->_vars['vote_ip'];
        elseif ($name === 'id')
            return $this->_vars['vote_id'];
        elseif ($name === 'created')
            return $this->_vars['vote_created'];
        elseif ($name === 'updated')
            return $this->_vars['vote_updated'];
        elseif ($name === 'user_id')
            return $this->_vars['vote_user_id'];
        elseif ($name === 'User')
            return $this->_fetchUser();
        else
            return $this->fetchObject($name);
    }

    public function __set($name, $value)
    {
        if ($name === 'entity_type')
            $this->_setVar('vote_entity_type', $value);
        elseif ($name === 'bundle_id')
            $this->_setVar('vote_bundle_id', $value);
        elseif ($name === 'entity_id')
            $this->_setVar('vote_entity_id', $value);
        elseif ($name === 'value')
            $this->_setVar('vote_value', $value);
        elseif ($name === 'tag')
            $this->_setVar('vote_tag', $value);
        elseif ($name === 'name')
            $this->_setVar('vote_name', $value);
        elseif ($name === 'comment')
            $this->_setVar('vote_comment', $value);
        elseif ($name === 'reference_id')
            $this->_setVar('vote_reference_id', $value);
        elseif ($name === 'ip')
            $this->_setVar('vote_ip', $value);
        elseif ($name === 'id')
            $this->_setVar('vote_id', $value);
        elseif ($name === 'user_id')
            $this->_setVar('vote_user_id', $value);
        elseif ($name === 'User')
            $this->_assignUser($value);
        else
            $this->assignObject($name, $value);
    }

    protected function _initVar($name, $value)
    {
        if ($name === 'vote_bundle_id')
            $this->_vars['vote_bundle_id'] = (int)$value;
        elseif ($name === 'vote_entity_id')
            $this->_vars['vote_entity_id'] = (int)$value;
        elseif ($name === 'vote_value')
            $this->_vars['vote_value'] = (float)$value;
        elseif ($name === 'vote_reference_id')
            $this->_vars['vote_reference_id'] = (int)$value;
        elseif ($name === 'vote_id')
            $this->_vars['vote_id'] = (int)$value;
        elseif ($name === 'vote_created')
            $this->_vars['vote_created'] = (int)$value;
        elseif ($name === 'vote_updated')
            $this->_vars['vote_updated'] = (int)$value;
        elseif ($name === 'vote_user_id')
            $this->_vars['vote_user_id'] = (int)$value;
        else
            $this->_vars[$name] = $value;
    }
}

abstract class Sabai_Addon_Voting_Model_Base_VoteRepository extends SabaiFramework_Model_EntityRepository
{
    public function __construct(SabaiFramework_Model $model)
    {
        parent::__construct('Vote', $model);
    }

    public function fetchByUser($id, $limit = 0, $offset = 0, $sort = null, $order = null)
    {
        return $this->_fetchByForeign('vote_user_id', $id, $limit, $offset, $sort, $order);
    }

    public function paginateByUser($id, $perpage = 10, $sort = null, $order = null)
    {
        return $this->_paginateByEntity('User', $id, $perpage, $sort, $order);
    }

    public function countByUser($id)
    {
        return $this->_countByForeign('vote_user_id', $id);
    }

    public function fetchByUserAndCriteria($id, SabaiFramework_Criteria $criteria, $limit = 0, $offset = 0, $sort = null, $order = null)
    {
        return $this->_fetchByForeignAndCriteria('vote_user_id', $id, $criteria, $limit, $offset, $sort, $order);
    }

    public function paginateByUserAndCriteria($id, SabaiFramework_Criteria $criteria, $perpage = 10, $sort = null, $order = null)
    {
        return $this->_paginateByEntityAndCriteria('User', $id, $criteria, $perpage, $sort, $order);
    }

    public function countByUserAndCriteria($id, SabaiFramework_Criteria $criteria)
    {
        return $this->_countByForeignAndCriteria('vote_user_id', $id, $criteria);
    }

    protected function _getCollectionByRowset(SabaiFramework_DB_Rowset $rs)
    {
        return new Sabai_Addon_Voting_Model_Base_VotesByRowset($rs, $this->_model->create('Vote'), $this->_model);
    }

    public function createCollection(array $entities = array())
    {
        return new Sabai_Addon_Voting_Model_Base_Votes($this->_model, $entities);
    }
}

class Sabai_Addon_Voting_Model_Base_VotesByRowset extends SabaiFramework_Model_EntityCollection_Rowset
{
    public function __construct(SabaiFramework_DB_Rowset $rs, Sabai_Addon_Voting_Model_Vote $emptyEntity, SabaiFramework_Model $model)
    {
        parent::__construct('Votes', $rs, $emptyEntity, $model);
    }

    protected function _loadRow(SabaiFramework_Model_Entity $entity, array $row)
    {
        $entity->initVars($row);
    }
}

class Sabai_Addon_Voting_Model_Base_Votes extends SabaiFramework_Model_EntityCollection_Array
{
    public function __construct(SabaiFramework_Model $model, array $entities = array())
    {
        parent::__construct($model, 'Votes', $entities);
    }
}