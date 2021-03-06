<?php
/**
 * Created by PhpStorm.
 * User: wilder16
 * Date: 10/04/18
 * Time: 17:10
 */

namespace Model;

class Bike
{
    private $id;
    private $name;
    private $description;
    private $photo_before;
    private $photo_after;
    private $rate_look;
    private $rate_practice;
    private $rate_fun;
    private $price;
    private $sold;
    private $is_kustom;
    private $is_sold;

    /**
     * @param array $attributes
     * @return Bike
     */
    public function hydrate(array $attributes) :Bike
    {
        foreach ($attributes as $attribute => $value) {
            $words = explode('_', $attribute);
            $upperWords = array_map('ucfirst', $words);
            $word = implode('', $upperWords);
            $method = 'set' . $word;

            if (method_exists(self::class, $method)) {
                if ($value === '') {
                    $value = null;
                }
                $this->$method($value);
            }
        }
        return $this;
    }

    public function checkPhotos(int $id = null)
    {
        $imagePath = '../assets/images/bikes/';

        foreach ($_FILES as $photo => $file) {
            if ($file['error'] === 0) {
                if ($id === null) {
                    $bikeManager = new BikeManager();
                    $newName = $bikeManager->nextAutoIncrement() + 1;
                } else {
                    $newName = $id;
                }

                if ($photo === 'photo_before') {
                    $newName .= '_before.';
                } elseif ($photo === 'photo_after') {
                    $newName .= '_after.';
                }

                $fileInfo = new \SplFileInfo($file['name']);
                $extension = $fileInfo->getExtension();
                $newName .= $extension;

                try {
                    $uploadedPhoto = new UplodedFile($file, $imagePath, $newName);
                    $uploadedPhoto->process('image/jpeg');
                } catch (\Exception $e) {
                }

                $newImagePath = $imagePath . $newName;
                $data = $_POST;
                if ($photo === 'photo_before') {
                    $path = substr($newImagePath, 2, mb_strlen($newImagePath)-2);
                    $data['photo_before'] = $path;
                } elseif ($photo === 'photo_after') {
                    $path = substr($newImagePath, 2, mb_strlen($newImagePath)-2);
                    $data['photo_after'] = $path;
                }
                return $data;
            }
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Bike
     */
    public function setId(int $id): Bike
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param string $name
     * @return Bike
     */
    public function setName(string $name): Bike
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return Bike
     */
    public function setDescription(?string $description): Bike
    {
        $this->description = $description;
        return $this;
    }


    /**
     * @return null|string
     */
    public function getPhotoBefore(): ?string
    {
        return $this->photo_before;
    }

    /**
     * @param null|string $photo_before
     * @return Bike
     */
    public function setPhotoBefore(?string $photo_before): Bike
    {
        $this->photo_before = $photo_before;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhotoAfter(): ?string
    {
        return $this->photo_after;
    }


    /**
     * @param string $photo_after
     * @return Bike
     */
    public function setPhotoAfter(string $photo_after): Bike
    {
        $this->photo_after = $photo_after;
        return $this;
    }


    /**
     * @return int
     */
    public function getRateLook(): int
    {
        if ($this->rate_look === null) {
            $this->rate_look = 1;
        }
        return $this->rate_look;
    }


    /**
     * @param int $rate_look
     * @return Bike
     */
    public function setRateLook(int $rate_look = 1): Bike
    {
        $this->rate_look = $rate_look;
        return $this;
    }


    /**
     * @return int
     */
    public function getRatePractice(): int
    {
        if ($this->rate_practice === null) {
            $this->rate_practice = 1;
        }
        return $this->rate_practice;
    }


    /**
     * @param int $rate_practice
     * @return Bike
     */
    public function setRatePractice(int $rate_practice = 1): Bike
    {
        $this->rate_practice = $rate_practice;
        return $this;
    }


    /**
     * @return int
     */
    public function getRateFun(): int
    {
        if ($this->rate_fun === null) {
            $this->rate_fun = 1;
        }
        return $this->rate_fun;
    }


    /**
     * @param int $rate_fun
     * @return Bike
     */
    public function setRateFun(int $rate_fun = 1): Bike
    {
        $this->rate_fun = $rate_fun;
        return $this;
    }


    /**
     * @return null|int
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }


    /**
     * @param int|null $price
     * @return Bike
     */
    public function setPrice(?int $price): Bike
    {
        $this->price = $price;
        return $this;
    }


    /**
     * @return bool
     */
    public function getSold(): bool
    {
        if ($this->sold === null) {
            $this->sold = false;
        }
        return $this->sold;
    }


    /**
     * @param bool $sold
     * @return Bike
     */
    public function setSold(bool $sold = false): Bike
    {
        $this->sold = $sold;
        return $this;
    }


    /**
     * @return bool
     */
    public function getIsKustom(): bool
    {
        if ($this->is_kustom === null) {
            $this->is_kustom = false;
        }
        return $this->is_kustom;
    }

    /**
     * @param bool $is_kustom
     * @return Bike
     */
    public function setIsKustom(bool $is_kustom = false): Bike
    {
        $this->is_kustom = $is_kustom;
        return $this;
    }


    /**
     * @return bool
     */
    public function getIsSold(): bool
    {
        if ($this->is_sold === null) {
            $this->is_sold = false;
        }
        return $this->is_sold;
    }


    /**
     * @param bool $is_sold
     * @return Bike
     */
    public function setIsSold(bool $is_sold = false): Bike
    {
        $this->is_sold = $is_sold;
        return $this;
    }
}
