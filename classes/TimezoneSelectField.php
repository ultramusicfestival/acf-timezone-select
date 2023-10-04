<?php

namespace ACFTimezoneSelect;

use ACA\ACF\Field\Type\ChoicesTrait;
use ACA\ACF\Field\Type\MultipleTrait;
use ACA\ACF\Field\Type\Select;

class TimezoneSelectField extends Select {

	use MultipleTrait;
	use ChoicesTrait;

    public function get_choices()
    {
        $settings = acf_prepare_field( $this->settings );
        return isset( $settings['choices'] ) && $settings['choices']
            ? (array) $settings['choices']
            : [];
    }
}