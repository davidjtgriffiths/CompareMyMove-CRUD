<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompanyMatchingSettings
 *
 * @ORM\Table(name="company_matching_settings", uniqueConstraints={@ORM\UniqueConstraint(name="unique_id", columns={"id"})}, indexes={@ORM\Index(name="lnk_companies_company_postcode_choices", columns={"company_id"})})
 * @ORM\Entity
 */
class CompanyMatchingSettings
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="postcodes", type="text", length=65535, nullable=false)
     */
    private $postcodes;

    /**
     * @var string
     *
     * @ORM\Column(name="bedrooms", type="text", length=65535, nullable=false)
     */
    private $bedrooms;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25, nullable=false)
     */
    private $type;

    /**
     * @var \Companies
     *
     * @ORM\ManyToOne(targetEntity="Companies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * })
     */
    private $company;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostcodes(): ?string
    {
        return $this->postcodes;
    }

    public function setPostcodes(string $postcodes): self
    {
        $this->postcodes = $postcodes;

        return $this;
    }

    public function getBedrooms(): ?string
    {
        return $this->bedrooms;
    }

    public function setBedrooms(string $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCompany(): ?Companies
    {
        return $this->company;
    }

    public function setCompany(?Companies $company): self
    {
        $this->company = $company;

        return $this;
    }


}
