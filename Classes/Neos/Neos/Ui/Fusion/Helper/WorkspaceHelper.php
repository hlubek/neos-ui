<?php
namespace Neos\Neos\Ui\Fusion\Helper;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\ContentRepository\Domain\Model\Workspace;
use Neos\Neos\Service\UserService;
use Neos\Neos\Ui\TYPO3CR\Service\WorkspaceService;

class WorkspaceHelper implements ProtectedContextAwareInterface
{
    /**
     * @Flow\Inject
     * @var WorkspaceService
     */
    protected $workspaceService;

    /**
     * @Flow\Inject
     * @var UserService
     */
    protected $userService;

    public function getPublishableNodeInfo(Workspace $workspace)
    {
        return $this->workspaceService->getPublishableNodeInfo($workspace);
    }


    public function getPersonalWorkspaceName()
    {
        return $this->userService->getPersonalWorkspace()->getName();
    }

    public function initializeWorkspacesByName()
    {
        $workspaces = [];

        $personalWorkspace = $this->userService->getPersonalWorkspace();

        $workspaces[$personalWorkspace->getName()] = [
            'name' => $personalWorkspace->getName(),
            'publishableNodes' => $this->getPublishableNodeInfo($personalWorkspace)
        ];

        return $workspaces;
    }

    /**
     * @param string $methodName
     * @return boolean
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
