<?php

declare(strict_types=1);
namespace AppBundle\Controller;

/**
 * Interface TestInterface.
 *
 * @author Carey Sizer <carey@balanceinternet.com.au>
 */
interface TestInterface
{
    const STATUS_NONE = 'none';
    const STATUS_RETRY = 'retry';
    const STATUS_ERROR = 'error';

    /**
     * Get the name of a given process that owns the status.
     */
    public function getProcess(): string;

    /**
     * Get the name of a given status for the process.
     */
    public function getStatus(): string;
}
