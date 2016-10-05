<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElasticIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $params = [
            'index' => config('elasticsearch.index'),
            'body' => [
                'mappings' => [
                    'zipcodes' => [
                        'properties' => [
                            'type' => ['type' => 'string'],
                            'properties' => [
                                'properties' => [
                                    'ZCTA5CE10' => ['type' => 'string'],
                                    'GEOID10' => ['type' => 'string'],
                                    // From Zip-Codes.com Data
                                    'ZipCode' => ['type' => 'string'],
                                    'PrimaryRecord' => ['type' => 'string'],
                                    'Population' => ['type' => 'integer'],
                                    'HouseholdsPerZipcode' => ['type' => 'integer'],
                                    'WhitePopulation' => ['type' => 'integer'],
                                    'BlackPopulation' => ['type' => 'integer'],
                                    'HispanicPopulation' => ['type' => 'integer'],
                                    'AsianPopulation' => ['type' => 'integer'],
                                    'HawaiianPopulation' => ['type' => 'integer'],
                                    'IndianPopulation' => ['type' => 'integer'],
                                    'OtherPopulation' => ['type' => 'integer'],
                                    'MalePopulation' => ['type' => 'integer'],
                                    'FemalePopulation' => ['type' => 'integer'],
                                    'PersonsPerHousehold' => ['type' => 'float'],
                                    'AverageHouseValue' => ['type' => 'integer'],
                                    'IncomePerHousehold' => ['type' => 'integer'],
                                    'MedianAge' => ['type' => 'float'],
                                    'MedianAgeMale' => ['type' => 'float'],
                                    'MedianAgeFemale' => ['type' => 'float'],
                                    'ZipPoint' => ['type' => 'geo_point'],
                                    'Latitude' => ['type' => 'float'],
                                    'Longitude' => ['type' => 'float'],
                                    'Elevation' => ['type' => 'integer'],
                                    'State' => ['type' => 'string'],
                                    'StateFullName' => ['type' => 'string'],
                                    'CityType' => ['type' => 'string'],
                                    'CityAliasAbbreviation' => ['type' => 'string'],
                                    'AreaCode' => ['type' => 'string'],
                                    'City' => ['type' => 'string'],
                                    'CityAliasName' => ['type' => 'string'],
                                    'County' => ['type' => 'string'],
                                    'CountyFIPS' => ['type' => 'string'],
                                    'StateFIPS' => ['type' => 'string'],
                                    'TimeZone' => ['type' => 'string'],
                                    'DayLightSaving' => ['type' => 'string'],
                                    'MSA' => ['type' => 'string'],
                                    'PMSA' => ['type' => 'string'],
                                    'CSA' => ['type' => 'string'],
                                    'CBSA' => ['type' => 'string'],
                                    'CBSA_DIV' => ['type' => 'string'],
                                    'CBSA_Type' => ['type' => 'string'],
                                    'CBSA_Name' => ['type' => 'string'],
                                    'MSA_Name' => ['type' => 'string'],
                                    'PMSA_Name' => ['type' => 'string'],
                                    'Region' => ['type' => 'string'],
                                    'Division' => ['type' => 'string'],
                                    'MailingName' => ['type' => 'string'],
                                    'NumberOfBusinesses' => ['type' => 'integer'],
                                    'NumberOfEmployees' => ['type' => 'integer'],
                                    'BusinessFirstQuarterPayroll' => ['type' => 'integer'],
                                    'BusinessAnnualPayroll' => ['type' => 'integer'],
                                    'BusinessEmploymentFlag' => ['type' => 'string'],
                                    'GrowthRank' => ['type' => 'integer'],
                                    'GrowingCountiesA' => ['type' => 'integer'],
                                    'GrowingCountiesB' => ['type' => 'integer'],
                                    'GrowthIncreaseNumber' => ['type' => 'integer'],
                                    'GrowthIncreasePercentage' => ['type' => 'float'],
                                    'CBSAPopulation' => ['type' => 'integer'],
                                    'CBSADivisionPopulation' => ['type' => 'integer'],
                                    'CongressionalDistrict' => ['type' => 'string'],
                                    'CongressionalLandArea' => ['type' => 'string'],
                                    'DeliveryResidential' => ['type' => 'integer'],
                                    'DeliveryBusiness' => ['type' => 'integer'],
                                    'DeliveryTotal' => ['type' => 'integer'],
                                    'PreferredLastLineKey' => ['type' => 'string'],
                                    'ClassificationCode' => ['type' => 'string'],
                                    'MultiCounty' => ['type' => 'string'],
                                    'CSAName' => ['type' => 'string'],
                                    'CBSA_DIV_Name' => ['type' => 'string'],
                                    'CityStateKey' => ['type' => 'string'],
                                    'PopulationEstimate' => ['type' => 'integer'],
                                    'LandArea' => ['type' => 'float'],
                                    'WaterArea' => ['type' => 'float'],
                                    'CityAliasCode' => ['type' => 'string'],
                                    'CityMixedCase' => ['type' => 'string'],
                                    'CityAliasMixedCase' => ['type' => 'string'],
                                    'BoxCount' => ['type' => 'integer'],
                                    'SFDU' => ['type' => 'integer'],
                                    'MFDU' => ['type' => 'integer'],
                                    'StateANSI' => ['type' => 'string'],
                                    'CountyANSI' => ['type' => 'string'],
                                    'ZIPIntro' => ['type' => 'string'],
                                    'AliasIntro' => ['type' => 'string'],
                                    'FacilityCode' => ['type' => 'string'],
                                    'CityDeliveryIndicator' => ['type' => 'string'],
                                    'CarrierRouteRateSortation' => ['type' => 'string'],
                                    'FinanceNumber' => ['type' => 'string'],
                                    'UniqueZIPName' => ['type' => 'string'],
                                ],
                            ],
                            'geometry' => ['type' => 'geo_shape'],
                        ]
                    ],
                ]
            ]
        ];
        ES::indices()->create($params);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $params = ['index' => config('elasticsearch.index')];
        ES::indices()->delete($params);
    }
}
