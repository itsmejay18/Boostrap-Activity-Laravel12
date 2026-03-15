<?php

test('guests are redirected to the login page from home', function () {
    $this->get('/')
        ->assertRedirect(route('login'));
});
