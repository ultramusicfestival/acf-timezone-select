<?php

namespace ACFTimezoneSelect;

class TimezoneSelectColumn extends \ACA\ACF\Column {

    public function set_config(array $config)
    {
        $config[\ACA\ACF\Configurable::FIELD] = new TimezoneSelectField($config[\ACA\ACF\Configurable::FIELD]->get_settings());
        parent::set_config($config);
    }

    public function editing()
    {
        $choices = $this->field instanceof \ACA\ACF\Field\Choices ? $this->field->get_choices() : [];
        $view = new \ACP\Editing\View\AdvancedSelect($choices);
        $storage = new \ACP\Editing\Storage\Meta($this->get_meta_key(), new \AC\MetaType($this->get_meta_type()));

        return $this->field instanceof \ACA\ACF\Field\Multiple && $this->field->is_multiple()
            ? new \ACA\ACF\Editing\Service\MultipleSelect( $view, $storage )
            : new \ACP\Editing\Service\Basic( $view, $storage );
    }

    public function filtering()
    {
        return $this->field instanceof \ACA\ACF\Field\Multiple && $this->field->is_multiple()
            ? new \ACA\ACF\Filtering\Model\SerializedChoices( $this, $this->field )
            : new \ACA\ACF\Filtering\Model\Choices( $this, $this->field );
    }

    public function search()
    {
        $choices = $this->field instanceof \ACA\ACF\Field\Choices ? $this->field->get_choices() : [];

        return $this->field instanceof \ACA\ACF\Field\Multiple && $this->field->is_multiple()
            ? new \ACA\ACF\Search\Comparison\MultiSelect( $this->get_meta_key(), $this->get_meta_type(), $choices )
            : new \ACA\ACF\Search\Comparison\Select( $this->get_meta_key(), $this->get_meta_type(), $choices );
    }

    public function sorting()
    {
        $choices = $this->field instanceof \ACA\ACF\Field\Choices ? $this->field->get_choices() : [];
        natcasesort($choices);

        $meta_type = $this->get_meta_type();
        $meta_key = $this->get_meta_key();

        return $this->field instanceof \ACA\ACF\Field\Multiple && $this->field->is_multiple()
            ? (new \ACP\Sorting\Model\MetaFormatFactory())->create(
                $meta_type,
                $meta_key,
                new \ACA\ACF\Sorting\FormatValue\Select($choices),
                null,
                [
                    'post_type' => $this->get_post_type(),
                    'taxonomy'  => $this->get_taxonomy(),
                ]
            )
            : (new \ACP\Sorting\Model\MetaMappingFactory())->create($meta_type, $meta_key, array_keys($choices));
    }

}