<?php

namespace ceLTIc\LTI\MediaType;

use ceLTIc\LTI\Tool;

/**
 * Class to represent an LTI Security Contract document
 *
 * @author  Stephen P Vickers <stephen@spvsoftwareproducts.com>
 * @copyright  SPV Software Products
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3
 */
class SecurityContract
{

    /**
     * Shared secret.
     *
     * @var string|null $shared_secret
     */
    public $shared_secret = null;

    /**
     * Services.
     *
     * @var array|null $tool_service
     */
    public $tool_service = null;

    /**
     * Class constructor.
     *
     * @param Tool    $tool  Tool instance
     * @param string $secret Shared secret
     */
    function __construct($tool, $secret)
    {
        $tcContexts = array();
        foreach ($tool->platform->profile->{'@context'} as $context) {
            if (is_object($context)) {
                $tcContexts = array_merge(get_object_vars($context), $tcContexts);
            }
        }

        $this->shared_secret = $secret;
        $toolServices = array();
        foreach ($tool->requiredServices as $requiredService) {
            foreach ($requiredService->formats as $format) {
                $service = $tool->findService($format, $requiredService->actions);
                if (($service !== false) && !array_key_exists($service->{'@id'}, $toolServices)) {
                    $id = $service->{'@id'};
                    $parts = explode(':', $id, 2);
                    if (count($parts) > 1) {
                        if (array_key_exists($parts[0], $tcContexts)) {
                            $id = "{$tcContexts[$parts[0]]}{$parts[1]}";
                        }
                    }
                    $toolService = new \stdClass;
                    $toolService->{'@type'} = 'RestServiceProfile';
                    $toolService->service = $id;
                    $toolService->action = $requiredService->actions;
                    $toolServices[$service->{'@id'}] = $toolService;
                }
            }
        }
        foreach ($tool->optionalServices as $optionalService) {
            foreach ($optionalService->formats as $format) {
                $service = $tool->findService($format, $optionalService->actions);
                if (($service !== false) && !array_key_exists($service->{'@id'}, $toolServices)) {
                    $id = $service->{'@id'};
                    $parts = explode(':', $id, 2);
                    if (count($parts) > 1) {
                        if (array_key_exists($parts[0], $tcContexts)) {
                            $id = "{$tcContexts[$parts[0]]}{$parts[1]}";
                        }
                    }
                    $toolService = new \stdClass;
                    $toolService->{'@type'} = 'RestServiceProfile';
                    $toolService->service = $id;
                    $toolService->action = $optionalService->actions;
                    $toolServices[$service->{'@id'}] = $toolService;
                }
            }
        }
        $this->tool_service = array_values($toolServices);
    }

}
