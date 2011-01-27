<?php

function formatFileSize($bytes) {
    if ($bytes < 1024) {
        return __(
            '!bytes Bytes',
            array(
                '!bytes' => $bytes
            )
        );
    }

    $kilobytes = $bytes / 1024;

    if ($kilobytes < 1024) {
        return __(
            '!kb Kb',
            array(
                '!kb' => (int) $kilobytes
            )
        );
    }

    $megabytes = round($kilobytes / 1024, 2);

    return __(
        '!mb MB',
        array(
            '!mb' => $megabytes
        )
    );
}