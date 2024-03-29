<?php
class ModelToolImage extends Model
{
	public function resize($filename, $width, $height, $new_image = '')
	{
		if (!is_file(DIR_IMAGE . $filename)) {
			if (is_file(DIR_IMAGE . 'no_image.png')) {
				$filename = 'no_image.png';
			} else {
				return;
			}
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $new_image) || (filectime(DIR_IMAGE . $old_image) > filectime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}

		if ($this->request->server['HTTPS']) {
			return HTTPS_CATALOG . 'image/' . $new_image;
		} else {
			return HTTP_CATALOG . 'image/' . $new_image;
		}
	}

	public function getImage($url_source, $new_image = '', $width = 0, $height = 0)
	{
		if (filter_var($url_source, FILTER_VALIDATE_URL)) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize($url_source);

			if ($width_orig > $width || $height_orig > $height) {
				$image = new Image($url_source);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy($url_source, DIR_IMAGE . $new_image);
			}

			return $new_image;
		} else {
			return;
		}
	}

	# This function is not used. Use this in case getImage function does not work.
	public function getImageByCurl($url_source, $new_image)
	{
		if (filter_var($url_source, FILTER_VALIDATE_URL)) {
			$headers = get_headers($url_source, 1);

			if (strpos($headers['Content-Type'], 'image/') !== false) {
				$url_destination = DIR_IMAGE . $new_image;

				$ch = curl_init($url_source);
				$fp = fopen($url_destination, 'wb');

				$options = array(
					CURLOPT_FILE => $fp,
					CURLOPT_HEADER => 0,
					CURLOPT_FOLLOWLOCATION => 1,
					CURLOPT_TIMEOUT => 20
				); // 1 minute timeout (should be enough)
				curl_setopt_array($ch, $options);

				// curl_setopt($ch, CURLOPT_TIMEOUT, 20);
				// curl_setopt($ch, CURLOPT_FILE, $fp);
				// curl_setopt($ch, CURLOPT_HEADER, 0);
				// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				
				curl_exec($ch);
				curl_close($ch);
				fclose($fp);

				return $new_image;
			}
		}

		return;
	}
}
