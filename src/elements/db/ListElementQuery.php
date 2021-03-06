<?php

namespace barrelstrength\sproutbaselists\elements\db;

use craft\elements\db\ElementQuery;
use craft\helpers\Db;

/**
 * Class ListElementQuery
 *
 * @package barrelstrength\sproutbaselists\elements\db
 */
class ListElementQuery extends ElementQuery
{
    public $type;

    public $elementId;

    public $handle;

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        switch ($name) {
            case 'type':
                $this->type($value);
                break;
            case 'elementId':
                $this->elementId($value);
                break;
            case 'handle':
                $this->handle($value);
                break;
            default:
                parent::__set($name, $value);
        }
    }

    /**
     * @param $value
     *
     * @return static self reference
     */
    public function type($value)
    {
        $this->type = $value;
        return $this;
    }

    /**
     * @param $value
     *
     * @return static self reference
     */
    public function elementId($value)
    {
        $this->elementId = $value;
        return $this;
    }

    /**
     * @param $value
     *
     * @return static self reference
     */
    public function handle($value)
    {
        $this->handle = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function beforePrepare(): bool
    {
        $this->joinElementTable('sproutlists_lists');

        $this->query->select([
            'sproutlists_lists.elementId',
            'sproutlists_lists.type',
            'sproutlists_lists.name',
            'sproutlists_lists.handle',
            'sproutlists_lists.count'
        ]);

        if ($this->type) {
            $listClass = new $this->type();
            $this->subQuery->andWhere(['sproutlists_lists.type' => get_class($listClass)]);
        }

        if ($this->elementId) {
            $this->subQuery->andWhere(Db::parseParam('sproutlists_lists.elementId', $this->elementId));
        }

        if ($this->handle) {
            $this->subQuery->andWhere(Db::parseParam('sproutlists_lists.handle', $this->handle));
        }

        return parent::beforePrepare();
    }
}