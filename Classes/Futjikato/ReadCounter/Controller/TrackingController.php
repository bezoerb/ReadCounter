<?php

namespace Futjikato\ReadCounter\Controller;

use Futjikato\ReadCounter\Exception\BadRequestException;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Flow\Persistence\Doctrine\PersistenceManager;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

/**
 * Tracking Controller provides an API so pages can increase their read counter via an AJAX call.
 */
class TrackingController extends ActionController
{
    /**
     * {@inheritdoc}
     */
    protected $supportedMediaTypes = array('application/json');

    /**
     * {@inheritdoc}
     */
    protected $defaultViewObjectName = 'TYPO3\Flow\Mvc\View\JsonView';

    /**
     * Persisstence Manager to save node changes in cr.
     *
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * Increase read counter of the node by one
     *
     * @param NodeInterface $node Node to increase the read counter for
     *
     * @throws BadRequestException
     * @return mixed[]
     */
    public function trackAction(NodeInterface $node)
    {
        // we can only count pages that include the mixin
        if($node->getNodeType()->isOfType('Futjikato.ReadCounter:CounterMixin')) {
            $node->setProperty('readcounter', $node->getProperty('readcounter') + 1);
            /**
             * Action changes data but is accessible via GET. this issues a error if we do not manually
             * persists the object in the persistence manager
             */
            $this->persistenceManager->persistAll();

            // by default the flow JSON view uses the 'value' variable
            $this->view->assign('value', array('readcounter' => $node->getProperty('readcounter')));
        } else {
            throw new BadRequestException('Node does not contain Futjikato.ReadCounter:CounterMixin.');
        }
    }

    /**
     * Setter injection for the persistence manager
     *
     * @param PersistenceManager $persistenceManager
     */
    public function injectPersistenceManager(PersistenceManager $persistenceManager)
    {
        $this->persistenceManager = $persistenceManager;
    }
}