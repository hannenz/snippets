
<?php

/*
 *  @author: syl-via@go2.pl & Suhail Doshi
 */

class TagcloudHelper extends Helper {
    /* font sizes */

    var $minSize = 11;
    var $maxSize = 50;

    /* show frequencies */
    var $show_frequencies = false;

    public $helpers = array('Html');

    /*  @author: syl-via
     *  @param array $tags Tags to build the cloud on. Ex array('name'=>20,'tag2'=>32)
     *  @param (optional) int  $minSize  Minimum size of the font
     *  @param (optional) int  $maxSize  Maximum size of the font
     * 
     *  returns string div with span of tags.
     */

    public function word_cloud($tags, $show_frequencies = null, $minSize = null, $maxSize = null) {
        if ($show_frequencies != null)
            $this->show_frequencies = $show_frequencies;
        if ($minSize != null)
            $this->minSize = $minSize;
        if ($maxSize != null)
            $this->maxSize = $maxSize;

        $data = $this->formulateTagCloud($tags);
        ksort ($data);

        /* Build cloud */
        $cloud = "<div>";
        foreach ($data as $word => $options) {

            $cloud .= $this->Html->link($word, 
                array(
                    'controller' => 'snippets',
                    'action' => 'index',
                    'tag_name' => str_replace(' ', '&nsbp;', $word)
                ),
                array(
                    'style' => 'font-size: '.$options['size'].'px'
                )
            );
            $cloud .= ' ';
        }
        $cloud .= "</div>";
        return $cloud;
    }

    /*
     *  @author: Suhail Doshi
     */

    public function formulateTagCloud($dataSet) {
        asort($dataSet); // Sort array accordingly.
        // Retrieve extreme score values for normalization
        $minimumScore = intval(current($dataSet));
        $maximumScore = intval(end($dataSet));

        // Populate new data array, with score value and size.
        foreach ($dataSet as $tagName => $score) {
            $size = $this->getPercentSize($maximumScore, $minimumScore, $score);
            $data[$tagName] = array('score' => $score, 'size' => $size);
        }

        return $data;
    }

    /*  @author: Suhail Doshi
     *  @param int $maxValue Maximum score value in array.
     *  @param int $minValue Minimum score value in array.
     *  @param int $currentValue Current score value for given item.
     *  @param int [$minSize] Minimum font-size.
     *  @param int [$maxSize] Maximum font-size.
     *
     *  returns int percentage for current tag.
     */

    private function getPercentSize($maximumScore, $minimumScore, $currentValue) {
        if ($minimumScore < 1)
            $minimumScore = 1;
        $spread = $maximumScore - $minimumScore;
        if ($spread == 0)
            $spread = 1;
        // determine the font-size increment, this is the increase per tag quantity (times used)
        $step = ($this->maxSize - $this->minSize) / $spread;
        // Determine size based on current value and step-size.
        $size = $this->minSize + (($currentValue - $minimumScore) * $step);
        return $size;
    }
}
?>  