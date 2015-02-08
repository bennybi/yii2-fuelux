<?php

namespace xemware\fuelux;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;


/**
 * @see http://exacttarget.github.io/fuelux/javascript.html#checkboxes
 * @author Leandrogehlen <leandroghelen@gmail.com>
 * @since 2.0
 */
class Datepicker extends InputWidget
{
    /**
     * @var boolean allow past date selection
     */
    public $allowPastDates = true;

    /**
     * @var mixed initial date
     */
    public $initialDate;

    /**
     * @var Array restrict date selection
     */
    public $restrictTo;

    /**
     * @var boolean same year selection only
     */
    public $sameYearOnly;

    private $_internalOptions;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initInternalOptions();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->renderDatepicker();
    }

    public static $months = [
        [0,'January']
    ];
    /**
     * Renders the datepicker
     */
    public function renderDatepicker()
    {
        Html::addCssClass($this->_internalOptions, 'datepicker');
        echo Html::beginTag('div', $this->_internalOptions) . "\n";
        echo Html::beginTag('div', ['class' => 'input-group']) . "\n";
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, ['class' => 'form-control']) . "\n";
        } else {
            echo Html::textInput($this->name, $this->value, ['class' => 'form-control']) . "\n";
        }

        /*
        echo Html::beginTag('div', ['class' => 'input-group-btn']) . "\n";

        echo Html::beginTag('button', ['type' => 'button','class' => 'btn btn-default dropdown-toggle','data' => ['toggle' => 'dropdown']]) . "\n";
        echo Html::tag('span', ['class' => 'glyphicon glyphicon-calendar']) . "\n";
        echo Html::tag('span', 'Toggle Calendar',['class' => 'sr-only']) . "\n";
        echo Html::endTag('button') . "\n"; // btn

        echo Html::beginTag('div', ['class' => 'dropdown-menu dropdown-menu-right datepicker-calendar-wrapper','role' => 'menu']) . "\n";
        echo Html::beginTag('div', ['class' => 'datepicker-calendar']) . "\n";
        // header
        echo Html::beginTag('div', ['class' => 'datepicker-calendar-header']) . "\n";


        // left
        echo Html::beginTag('button', ['type' => 'button','class' => 'prev']) . "\n";
        echo Html::tag('span', ['class' => 'glyphicon glyphicon-chevron-left']) . "\n";
        echo Html::tag('span', 'Previous Month',['class' => 'sr-only']) . "\n";
        echo Html::endTag('button') . "\n"; // btn

        echo Html::beginTag('button', ['type' => 'button','class' => 'next']) . "\n";
        echo Html::tag('span', ['class' => 'glyphicon glyphicon-chevron-right']) . "\n";
        echo Html::tag('span', 'Next Month',['class' => 'sr-only']) . "\n";
        echo Html::endTag('button') . "\n"; // btn

        echo Html::beginTag('button', ['type' => 'button','class' => 'title']) . "\n";
        echo Html::beginTag('span', ['class' => 'month']) . "\n";
        foreach(self::months as $month)
        {
            echo Html::tag('span',$month[1],['data' => ['month' => $month[0]]);
        }
        echo Html::endTag('span') . "\n"; // header month
        echo Html::tag('span','',['class' => 'year']);

        echo Html::endTag('button') . "\n"; // header title
        echo Html::endTag('div') . "\n"; // datepicker-calendar-header
        echo Html::endTag('div') . "\n"; // datepicker-calendar
        echo Html::endTag('div') . "\n"; // datepicker-calendar-wrapper
        echo Html::endTag('div') . "\n"; // input-group-btn
        */
        echo '
 <div class="input-group-btn">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon glyphicon-calendar"></span>
        <span class="sr-only">Toggle Calendar</span>
      </button>
      <div class="dropdown-menu dropdown-menu-right datepicker-calendar-wrapper" role="menu">
        <div class="datepicker-calendar">
          <div class="datepicker-calendar-header">
            <button type="button" class="prev"><span class="glyphicon glyphicon-chevron-left"></span><span class="sr-only">Previous Month</span></button>
            <button type="button" class="next"><span class="glyphicon glyphicon-chevron-right"></span><span class="sr-only">Next Month</span></button>
            <button type="button" class="title">
                <span class="month">
                  <span data-month="0">January</span>
                  <span data-month="1">February</span>
                  <span data-month="2">March</span>
                  <span data-month="3">April</span>
                  <span data-month="4">May</span>
                  <span data-month="5">June</span>
                  <span data-month="6">July</span>
                  <span data-month="7">August</span>
                  <span data-month="8">September</span>
                  <span data-month="9">October</span>
                  <span data-month="10">November</span>
                  <span data-month="11">December</span>
                </span> <span class="year"></span>
            </button>
          </div>
          <table class="datepicker-calendar-days">
            <thead>
            <tr>
              <th>Su</th>
              <th>Mo</th>
              <th>Tu</th>
              <th>We</th>
              <th>Th</th>
              <th>Fr</th>
              <th>Sa</th>
            </tr>
            </thead>
            <tbody></tbody>
          </table>
          <div class="datepicker-calendar-footer">
            <button type="button" class="datepicker-today">Today</button>
          </div>
        </div>
        <div class="datepicker-wheels" aria-hidden="true">
          <div class="datepicker-wheels-month">
            <h2 class="header">Month</h2>
            <ul>
              <li data-month="0"><button type="button">Jan</button></li>
              <li data-month="1"><button type="button">Feb</button></li>
              <li data-month="2"><button type="button">Mar</button></li>
              <li data-month="3"><button type="button">Apr</button></li>
              <li data-month="4"><button type="button">May</button></li>
              <li data-month="5"><button type="button">Jun</button></li>
              <li data-month="6"><button type="button">Jul</button></li>
              <li data-month="7"><button type="button">Aug</button></li>
              <li data-month="8"><button type="button">Sep</button></li>
              <li data-month="9"><button type="button">Oct</button></li>
              <li data-month="10"><button type="button">Nov</button></li>
              <li data-month="11"><button type="button">Dec</button></li>
            </ul>
          </div>
          <div class="datepicker-wheels-year">
            <h2 class="header">Year</h2>
            <ul></ul>
          </div>
          <div class="datepicker-wheels-footer clearfix">
            <button type="button" class="btn datepicker-wheels-back"><span class="glyphicon glyphicon-arrow-left"></span><span class="sr-only">Return to Calendar</span></button>
            <button type="button" class="btn datepicker-wheels-select">Select <span class="sr-only">Month and Year</span></button>
          </div>
        </div>
      </div>
    </div>
';
        echo Html::endTag('div') . "\n"; // input-group
        echo Html::endTag('div') . "\n"; // datepicker

    }

    /**
     * Initializes the internal options.
     * This method sets the default values for various options.
     */
    protected function initInternalOptions()
    {
        $this->_internalOptions = [
            'id' => ArrayHelper::remove($this->options, 'id'),
            'data-initialize' => 'datepicker'
        ];

    }

} 