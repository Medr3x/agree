<?php

function user(){
    return \Auth::user();
}


if (!function_exists('log_exception')) {
    function log_exception(\Exception $exception = null, $object = null, $action = null, $message = null, $echo_message = false)
    {
        logger(array_slice(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2), -1));

        if ($exception) {
            report($exception);
            $message = $exception->getMessage() . '. ' . ($message ?? '');
        }

        $activity = activity()
            ->inLog('exception')
            ->withProperties(['attributes' => ['action' => $action, 'object' => $object, 'message' => $message]]);

        if (user()) {
            $activity = $activity->causedBy(user());
        }

        $activity = $activity->log(str_limit($message, 180));
    }
}