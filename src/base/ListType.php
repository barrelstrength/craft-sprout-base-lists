<?php

namespace barrelstrength\sproutbaselists\base;

use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutbaselists\models\Settings;
use craft\base\Component;

/**
 *
 * @property mixed $className
 */
abstract class ListType extends Component
{
    /**
     * Set this value to true if a List Type should require an email address when processing a subscription.
     *
     * @var bool
     */
    public $requireEmailForSubscription = false;

    /**
     * @var Settings $settings
     */
    public $settings;

    public function init()
    {
        $this->settings = SproutBase::$app->settings->getPluginSettings('sprout-lists');

        parent::init();
    }

    /**
     * Returns the class name of this List Type
     *
     * @return mixed
     */
    final public function getClassName()
    {
        return str_replace('Craft\\', '', get_class($this));
    }

    /**
     * Prepare the Subscription model for the `add` and `remove` methods
     *
     * @return SubscriptionInterface
     */
    abstract public function populateSubscriptionFromPost(): SubscriptionInterface;

    /**
     * Subscribe a user to a list for this List Type
     *
     * @param SubscriptionInterface $subscription
     *
     * @return bool
     */
    abstract public function add(SubscriptionInterface $subscription): bool;

    /**
     * Unsubscribe a user from a list for this List Type
     *
     * @param SubscriptionInterface $subscription
     *
     * @return bool
     */
    abstract public function remove(SubscriptionInterface $subscription): bool;

    /**
     * @param SubscriptionInterface $subscription
     */
    abstract public function getList(SubscriptionInterface $subscription);

    /**
     * Prepare the ListElement for the `saveList` method
     *
     * @return ListInterface
     */
    abstract public function populateListFromPost(): ListInterface;

    /**
     * @param ListInterface $list
     *
     * @return bool
     */
    abstract public function saveList(ListInterface $list): bool;

    /**
     * @param ListInterface $list
     *
     * @return bool
     */
    abstract public function deleteList(ListInterface $list): bool;

    /**
     * @param SubscriptionInterface $subscription
     *
     * @return SubscriptionInterface|null
     */
    abstract public function getSubscriberOrItem(SubscriptionInterface $subscription);

    /**
     * Get all subscriptions for a given list.
     *
     * @param ListInterface $list
     *
     * @return mixed
     * @internal param $criteria
     */
    abstract public function getSubscriptions(ListInterface $list);

    /**
     * Prepare the Subscription model for the `isSubscribed` method.
     * The Subscription info is passed as `params` to the isSubscribed method.
     *
     * @example
     * {% if craft.sproutLists.isSubscribed(params) %} ... {% endif %}
     *
     * @param array $criteria
     *
     * @return SubscriptionInterface
     */
    abstract public function populateSubscriptionFromCriteria(array $criteria = []): SubscriptionInterface;

    /**
     * Check if a user is subscribed to a list
     *
     * @param SubscriptionInterface $subscription
     *
     * @return bool
     */
    abstract public function isSubscribed(SubscriptionInterface $subscription): bool;

    /**
     * @param ListInterface $list
     *
     * @return int
     */
    abstract public function getCount(ListInterface $list): int;
}