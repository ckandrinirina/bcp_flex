<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
{
    const FILTER_200 = "square_200";
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="uri", type="string", length=255, nullable=true)
     */
    private $uri;
    
    /**
     * @var string
     *
     * @ORM\Column(name="photo_type", type="string", length=255, nullable=true)
     */
    private $type;
    
    /**
     * @var int
     *
     * @ORM\Column(name="etablissement_id", type="integer", nullable=true)
     */
    private $idEtablissement;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Etablissement",cascade={"persist"}, inversedBy="photos")
     * @ORM\JoinColumn(name="etablissement_id", referencedColumnName="id", nullable=true)
     */
    private $etablissement;
    
    /**
     * @var int
     *
     * @ORM\Column(name="offre_id", type="integer", nullable=true)
     */
    private $idOffre;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Offre",cascade={"persist"}, inversedBy="photos")
     * @ORM\JoinColumn(name="offre_id", referencedColumnName="id", nullable=true)
     */
    private $offre;
    
    /**
     * @Assert\NotNull(message="cette champ est obligatoire")
     */
    private $file;
    
    public function __construct(UploadedFile $file, $dir) {
        $this->setFile($file);
        $this->uploadProfilePicture($dir);
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set uri
     *
     * @param string $uri
     *
     * @return Photo
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }
    
    
    public function getIdEtablissement() {
        return $this->idEtablissement;
    }

    public function getEtablissement() {
        return $this->etablissement;
    }

    public function getIdOffre() {
        return $this->idOffre;
    }

    public function getOffre() {
        return $this->offre;
    }

    public function setIdEtablissement($idEtablissement) {
        $this->idEtablissement = $idEtablissement;
    }

    public function setEtablissement(Etablissement $etablissement) {
        $this->etablissement = $etablissement;
    }

    public function setIdOffre($idOffre) {
        $this->idOffre = $idOffre;
    }

    public function setOffre(Offre $offre) {
        $this->offre = $offre;
    }
    
    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }
    
    
    public function getFile(){
        return $this->file;
    }

    public function setFile(UploadedFile $file){
        $this->file = $file;

        return $this;
    }
    
    public function getWebPath() {
        return null === $this->photo ? null : $this->getUploadDir().'/'.$this->photo;
    }

    protected function getUploadRootDir() {
        return __DIR__.'/../../web/assets/'.$this->getUploadDir();
    }

    protected function getUploadDir() {
        return 'img/uploads';
    }

    public function uploadProfilePicture($dir) {
        if ($this->file) {
            $name = uniqid().'_'.$this->file->getClientOriginalName();
            $this->file->move($dir, $this->file->getClientOriginalName());
            rename($dir.$this->file->getClientOriginalName(), $dir.$name);
            $this->uri = $name;
            $this->file = null;
        }
    }
    
    public function createThumb($oDataManager, $oFilterManager, $_nameFilter = "square_200", $_filter = []) {
        try {
            if (!empty($dir.$this->uri) && file_exists($dir.$this->uri) && $oDataManager && $oFilterManager) {
                $image = $oDataManager->find($_nameFilter, $dir.$this->uri);
                $response = $oFilterManager->applyFilter($image, $_nameFilter, $_filter);
                $thumb = $response->getContent();
                $f = ($dir.$this->uri)?fopen($dir.$this->uri, 'wb'):fopen($dir.$this->uri, 'wb');
                fwrite($f, $thumb);
                fclose($f);
                return true;
            }
            return $dir.$this->uri;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

}

