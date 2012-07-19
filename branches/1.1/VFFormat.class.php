<?php

/**
 * Visual Factory Format
 * 
 * Class representing format of the image that shall be resized.
 *
 * @package    VisualFactory
 * @author     Tomasz Ducin <tomasz.ducin@gmail.com>
 */
class VFFormat
{
  /**
   * Original upoaded image format. No transformation are done, raw file is just
   * uploaded.
   *
   * @var Boolean
   */
  private $original = false;

  /**
   * Format width.
   *
   * @var Integer
   */
  private $width;

  /**
   * Format height.
   *
   * @var Integer
   */
  private $height;

  /**
   * Format flip. Flip determines whether the image shall be flipped from
   * horizontal to vertical (or the other way) in case the declared format and
   * the real image dimensions does not match.
   *
   * @var Boolean
   */
  private $flip = true;

  /**
   * Upload directory.
   *
   * @var String
   */
  private $directory;

  /**
   * Internal Format constructor
   *
   * @param Boolean $original
   * @param String $directory
   */
  public function __construct($original, $directory)
  {
    $this->original = $original;
    $this->directory = $directory;
  }

  /**
   * Virtual multiple constructor. Creates format object from a array of parameters.
   * 
   * @param Array $params
   */
  static public function constructOrig(Array $params)
  {
    $instance = new self(true, $params['directory']);
    $instance->readFormatParameters($params['width'], $params['height'], $params['flip']);
    return $instance;
  }

  /**
   * Virtual multiple constructor. Creates format object from a array of parameters.
   * 
   * @param Array $params
   */
  static public function constructFromArray(Array $params)
  {
    $instance = new self(false, $params['directory']);
    $instance->readFormatParameters($params['width'], $params['height'], $params['flip']);
    return $instance;
  }

  /**
   * Virtual multiple constructor. Creates format object from data parameters.
   * 
   * @param Integer $width
   * @param Integer $height
   * @param Boolean $flip
   */
  static public function constructFromData($width, $height, $flip)
  {
    $instance = new self(false);
    $instance->readFormatParameters($width, $height, $flip);
    return $instance;
  }

  /**
   * Sets object properties from parameters.
   *
   * @param Integer $width
   * @param Integer $height
   * @param Boolean $flip
   */
  private function readFormatParameters($width, $height, $flip)
  {
    $this->width = $width;
    $this->height = $height;
    $this->flip = (is_bool($flip) ? $flip : $this->readFlipValue($flip));
  }

  /**
   * Reads and returns flip parameter as a boolean value.
   *
   * @param String $flip_param
   * @return Boolean
   * @throws Exception 
   */
  private function readFlipValue($flip_param)
  {
    switch (strtolower($flip_param))
    {
      case 'true':
        return true;
      case 'false':
        return false;
      default:
        throw new Exception('Unknown flip parameter. Should be either "true" or "false"');
    }
  }

  /**
   * Returns format width.
   *
   * @return Integer
   */
  public function getWidth()
  {
    return $this->width;
  }

  /**
   * Returns format height.
   *
   * @return Integer
   */
  public function getHeight()
  {
    return $this->height;
  }

  /**
   * Returns format flip property.
   *
   * @return Boolean
   */
  public function getFlip()
  {
    return $this->flip;
  }

  /**
   * Returns format upload directory.
   *
   * @return String
   */
  public function getDirectory()
  {
    return $this->directory;
  }

  /**
   * Returns format as a string: width x height.
   *
   * @return Integer
   */
  public function getUploadDirectory()
  {
    return $this->getDirectory().'/'.$this->getDimensionDirectory().'/';
  }

  /**
   * Returns dimension directory: [width x height] or literally [orig].
   *
   * @return Integer
   */
  public function getDimensionDirectory()
  {
    return $this->original ? 'orig' : $this->getWidth().'x'.$this->getHeight();
  }
}

?>