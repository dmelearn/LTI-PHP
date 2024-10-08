<?php

namespace ceLTIc\LTI;

/**
 * Class to represent an outcome
 *
 * @author  Stephen P Vickers <stephen@spvsoftwareproducts.com>
 * @copyright  SPV Software Products
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3
 */
class Outcome
{

    /**
     * Allowed values for Activity Progress.
     */
    const ALLOWED_ACTIVITY_PROGRESS = array(
        'Initialized',
        'Started',
        'InProgress',
        'Submitted',
        'Completed'
    );

    /**
     * Allowed values for Grading Progress.
     */
    const ALLOWED_GRADING_PROGRESS = array(
        'FullyGraded',
        'Pending',
        'PendingManual',
        'Failed',
        'NotReady'
    );

    /**
     * Language value.
     *
     * @var string|null $language
     */
    public $language = null;

    /**
     * Outcome status value.
     *
     * @var string|null $status
     */
    public $status = null;

    /**
     * Outcome date value.
     *
     * @var string|null $date
     */
    public $date = null;

    /**
     * Outcome type value.
     *
     * @var string|null $type
     */
    public $type = null;

    /**
     * Activity progress.
     *
     * @var string|null $activityProgress
     */
    public $activityProgress = null;

    /**
     * Grading progress.
     *
     * @var string|null $gradingProgress
     */
    public $gradingProgress = null;

    /**
     * Comment.
     *
     * @var string|null $comment
     */
    public $comment = null;

    /**
     * Outcome data source value.
     *
     * @var string|null $dataSource
     */
    public $dataSource = null;

    /**
     * LTI user ID.
     *
     * @var string|null $ltiUserId
     */
    public $ltiUserId = null;

    /**
     * Outcome value.
     *
     * @var string|null $value
     */
    private $value = null;

    /**
     * Points possible value.
     *
     * @var int $pointsPossible
     */
    private $pointsPossible = 1;

    /**
     * Class constructor.
     *
     * @param mixed  $value             Outcome value (optional, default is none)
     * @param int    $pointsPossible    Points possible value (optional, default is none)
     * @param string $activityProgress  Activity progress (optional, default is 'Completed')
     * @param string $gradingProgress  Grading progress (optional, default is 'FullyGraded')
     */
    public function __construct($value = null, $pointsPossible = 1, $activityProgress = 'Completed',
        $gradingProgress = 'FullyGraded')
    {
        $this->value = $value;
        $this->pointsPossible = $pointsPossible;
        $this->language = 'en-US';
        $this->date = gmdate('Y-m-d\TH:i:s\Z', time());
        $this->type = 'decimal';
        if (in_array($activityProgress, self::ALLOWED_ACTIVITY_PROGRESS)) {
            $this->activityProgress = $activityProgress;
        } else {
            $this->activityProgress = 'Completed';
        }
        if (in_array($gradingProgress, self::ALLOWED_GRADING_PROGRESS)) {
            $this->gradingProgress = $gradingProgress;
        } else {
            $this->gradingProgress = 'FullyGraded';
        }
        $this->comment = '';
        $this->ltiUserId = null;
    }

    /**
     * Get the outcome value.
     *
     * @return string|null Outcome value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the outcome value.
     *
     * @param string|null $value  Outcome value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get the points possible value.
     *
     * @return int|null Points possible value
     */
    public function getPointsPossible()
    {
        return $this->pointsPossible;
    }

    /**
     * Set the points possible value.
     *
     * @param int|null $pointsPossible  Points possible value
     */
    public function setPointsPossible($pointsPossible)
    {
        $this->pointsPossible = $pointsPossible;
    }

    /**
     * Assign property values from another outcome instance.
     *
     * @param Outcome $outcome  Outcome instance
     */
    public function assign($outcome)
    {
        foreach (get_object_vars($outcome) as $name => $value) {
            $this->$name = $value;
        }
    }

}
