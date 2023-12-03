<?php

test('Not debugging statements are left in our code.')
    ->expect(['dd', 'dump', 'ray', 'ds'])
    ->not->toBeUsed();
