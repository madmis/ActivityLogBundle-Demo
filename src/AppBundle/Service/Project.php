<?php

namespace AppBundle\Service;

use ActivityLogBundle\Entity\LogEntry;
use ActivityLogBundle\Entity\LogEntryInterface;
use ActivityLogBundle\Service\ActivityLog\EntityFormatter\AbstractFormatter;
use ActivityLogBundle\Service\ActivityLog\EntityFormatter\FormatterInterface;

/**
 * Class Project
 */
class Project extends AbstractFormatter implements FormatterInterface
{
    /**
     * @param LogEntry $log
     * @return array
     */
    public function format(LogEntryInterface $log)
    {
        $result = $log->toArray();

        $name = substr(strrchr(rtrim($log->getObjectClass(), '\\'), '\\'), 1);
        if ($log->isCreate()) {
            $result['message'] = sprintf('The custom entity <b>%s (%s)</b> was created.', $log->getName(), $name);
        } else if ($log->isRemove()) {
            $result['message'] = sprintf('The custom entity <b>%s (%s)</b> was removed.', $log->getName(), $name);
        } else if ($log->isUpdate()) {
            $result['message'] = sprintf(
                'The custom entity <b>%s (%s)</b> was updated.<br><b>Prev. data:</b> %s<br><b>New data:</b> %s',
                $log->getName(),
                $name,
                $this->toComment($log->getData()),
                $this->toComment($log->getOldData())
            );
        } else {
            $result['message'] = "Undefined action: {$log->getAction()}.";
        }

        return $result;
    }
}
