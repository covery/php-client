<?php

namespace Covery\Client\Envelopes;

class MediaStorageValidator
{
    public static $dataValuesForContentType = array(
        'image/jpeg', 'image/png', 'image/gif'
    );

    public static $dataValuesForContentDescription = array(
        'personal_photo', 'linked_document', 'general_document'
    );
}
