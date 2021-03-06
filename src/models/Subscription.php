<?php

namespace barrelstrength\sproutbaselists\models;

use barrelstrength\sproutbaselists\base\ListType;
use barrelstrength\sproutbaselists\base\SubscriptionInterface;
use barrelstrength\sproutbaselists\records\Subscription as SubscriptionRecord;
use craft\base\Model;
use DateTime;
use craft\validators\UniqueValidator;

class Subscription extends Model implements SubscriptionInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var ListType
     */
    public $listType;

    /**
     * @var string
     */
    public $listHandle;

    /**
     * @var
     */
    public $listId;

    /**
     * @var
     */
    public $elementId;

    /**
     * @var int
     */
    public $itemId;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var DateTime|null
     */
    public $dateCreated;

    /**
     * @var DateTime|null
     */
    public $dateUpdated;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getListType(): ListType
    {
        return $this->listType;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $rules[] = [
            ['email'],
            'required',
            'on' => [self::SCENARIO_SUBSCRIBER]
        ];

        $rules[] = [
            ['listId'],
            'required',
            'when' => function() {
                return !self::SCENARIO_SUBSCRIBER;
            }
        ];
        $rules[] = [['email'], 'email'];
        $rules[] = [
            ['listId', 'itemId'],
            UniqueValidator::class,
            'targetClass' => SubscriptionRecord::class,
            'targetAttribute' => ['listId', 'itemId']
        ];

        return $rules;
    }
}
