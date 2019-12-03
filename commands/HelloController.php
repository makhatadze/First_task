<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\LogAnswer;
use app\models\Result;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }
    public function actionLog() {
        $logs = LogAnswer::find()->asArray()->with(['quiz'])->all();
        foreach ($logs as $log) {

            if ($log['created_at']) {
                // now
                $time = time () + (4 * 60 * 60);
                $created_at = $log['created_at'] + 2 * 60 * 60;
                $quiz_time = $log['quiz']['quiz_time'] * 60;
                if ($time - ($created_at + $quiz_time) > 0 ) {
                    $model = new Result();
                    $model->finishTime($log['quiz']['id']);
                }
            }
        }
    }
}
