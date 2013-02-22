<?php

/**
 * class for rendering a static GoogleMaps image given a lat-long or an address, with an optional single marker in the center
 */
class EtuDev_GoogleMaps_Static {

	protected $id;

	protected $zoom = 14;
	protected $latitude;
	protected $longitude;

	protected $address;

	protected $height = 300;
	protected $width = 680;

	protected $maptype = 'roadmap';

	protected $color_marker = 'blue';
	protected $label_marker = 'R';

	protected $show_marker = false;

	protected $default_path = 'Spain';

	/**
	 *
	 * @param string $id Map's div id
	 */
	public function __construct($id = 'etudev_gmap') {
		$this->id = $id;
	}

	/**
	 * @return EtuDev_GoogleMaps_Static
	 */
	public function setShowMarker() {
		$this->show_marker = true;
		return $this;
	}

	/**
	 * @return EtuDev_GoogleMaps_Static
	 */
	public function unsetShowMarker() {
		$this->show_marker = false;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isShowMarker() {
		return $this->show_marker;
	}

	/**
	 * @param string $w
	 *
	 * @return EtuDev_GoogleMaps_Static
	 */
	public function setMapType($w) {
		$this->maptype = $w;
		return $this;
	}


	/**
	 * @param float|string $w
	 *
	 * @return EtuDev_GoogleMaps_Static
	 */
	public function setWidth($w) {
		$this->width = $w;
		return $this;
	}

	/**
	 * @param float|string $h
	 *
	 * @return EtuDev_GoogleMaps_Static
	 */
	public function setHeight($h) {
		$this->height = $h;
		return $this;
	}

	/**
	 * @param float|string $zoom
	 *
	 * @return EtuDev_GoogleMaps_Static
	 */
	public function setZoom($zoom) {
		$this->zoom = $zoom;
		return $this;
	}

	/**
	 * @param float|string $latitude
	 *
	 * @return EtuDev_GoogleMaps_Static
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
		return $this;
	}

	/**
	 * @param float|string $longitude
	 *
	 * @return EtuDev_GoogleMaps_Static
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
		return $this;
	}


	/**
	 * @param string $colorMarker
	 *
	 * @return EtuDev_GoogleMaps_Static
	 */
	public function setColorMarker($colorMarker) {
		$this->color_marker = $colorMarker;
		return $this;
	}

	/**
	 * @param string $labelMarker
	 *
	 * @return EtuDev_GoogleMaps_Static
	 */
	public function setLabelMarker($labelMarker) {
		$this->label_marker = $labelMarker;
		return $this;
	}

	/**
	 * @param string $ad
	 *
	 * @return EtuDev_GoogleMaps_Static
	 */
	public function setAddress($ad) {
		$this->address = $ad;
		return $this;
	}

	public function getZoom() {
		return $this->zoom;
	}

	public function getMapType() {
		return $this->maptype;
	}

	public function getWidth() {
		return $this->width;
	}

	public function getHeight() {
		return $this->height;
	}

	public function getLatitude() {
		if ($this->latitude) {
			return $this->latitude;
		}

		return 0;
	}

	public function getLongitude() {
		if ($this->longitude) {
			return $this->longitude;
		}

		return 0;
	}

	public function getAddress() {
		if ($this->address) {
			return $this->address;
		}

		return null;
	}


	/**
	 * @return string $colorMarker
	 */
	public function getColorMarker() {
		return $this->color_marker;
	}

	/**
	 * @return string $labelMarker
	 */
	public function getLabelMarker() {
		return $this->label_marker;
	}


	public function getURL() {

		$h = "http://maps.google.com/maps/api/staticmap?";

		if ($this->getLongitude() && $this->getLatitude()) {
			$h .= 'center=' . $this->getLatitude() . ',' . $this->getLongitude();
		} elseif ($this->getAddress()) {
			$h .= 'center=' . urlencode($this->getAddress());
		} else {
			$h .= 'center=0,0';
		}

		$h .= '&zoom=' . $this->getZoom();

		$h .= '&size=' . $this->getWidth() . 'x' . $this->getHeight();

		$h .= '&maptype=' . ($this->getMapType() ? : 'roadmap');

		if ($this->isShowMarker()) {
			$h .= '&markers=color:' . ($this->getColorMarker() ? : 'blue');
			$h .= '|label:' . ($this->getLabelMarker() ? : 'R');
			$h .= '|' . $this->getLatitude();
			$h .= ',' . $this->getLongitude();
		}

		$h .= '&sensor=false';

		return $h;
	}

	public function render() {
		return '<img src="' . $this->getURL() . '" height="' . $this->getHeight() . '" width="' . $this->getWidth() . '" />';
	}

	public function __toString() {
		return $this->render();
	}
}
