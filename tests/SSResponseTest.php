<?php

use Konnco\SatSet\Helpers\SSResponse;

it('will return normal response', function () {
    $response = SSResponse::make()
        ->content('success')
        ->send();

    $this->assertEquals($response->getOriginalContent(), ['data' => 'success']);
});
