<?php
namespace Sub\Strategy;

class Strategy_Context
{
    private $strategy;
    private $strategy_options;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
        $this->strategy_options = get_option('plug_settings');
    }


    public function setStrategy(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function mutual_method(): string
    {

        $url = $this->strategy_options['input_text_field_0'];
        return $this->strategy->change_color($url);
    }
}

interface Strategy
{
    public function change_color($url):string;

}


class ClassRed implements Strategy
{

    public function change_color($url):string
    {
        return '<div class="animate"><p><a style="color:#ff0000" target="_blanket" href="' . esc_url($url) . '">' . esc_url($url) . '</a></p><br></div>';
    }
}

class ClassGreen implements Strategy
{

    public function change_color($url):string
    {

        return '<div class="animate"><p><a style="color:green" target="_blanket" href="' . esc_url($url) . '">' . esc_url($url) . '</a></p><br></div>';
    }
}

class ClassBlue implements Strategy
{

    public function change_color($url):string
    {

        return '<div class="animate"><p><a style="color:blue" target="_blanket" href="' . esc_url($url) . '">' . esc_url($url) . '</a></p><br></div>';
    }
}

class ClassBlack implements Strategy
{

    public function change_color($url):string
    {
        return '<div class="animate"><p><a style="color:black" target="_blanket" href="' . esc_url($url) . '">' . esc_url($url) . '</a></p><br></div>';
    }
}


