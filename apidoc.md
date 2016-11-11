FORMAT: 1A

# Zipcodes
Various Zipcode-Related Searches

## Zipcodes Resource

### Get Boundaries by zipcodes [GET /api/zips/boundaries{?q}{&file}{&geojson}]
Get all the boundaries given a comma-delimited list of Zipcodes

+ Parameters
  + q (string) - comma-delimited list of Zipcodes
  + file (boolean, optional) - if `true`, the response will be downloaded as a file.  
    Default: `false`
    
  + geojson (boolean, optional) - if true, the response will be formated as valid GeoJSON.  Otherwise, it will be wrapped within `data` along with a `status` property.  
    Default: `false`
      
+ Response 200 (application/json)
    + Attributes (object)
      + status: success (string)
      + data (GeoJson)

### Get Boundaries by city name [GET /api/zips/boundaries/search{?city}{&state}{&file}{&geojson}] 
Get all the boundaries given a city name and state abbreviation

+ Parameters
    + city (string) - City Name
    + state (string) - The State
    + file (boolean, optional) - if true, the response will be downloaded as a file.  
    Default: `false`
    
    + geojson (boolean, optional) - if `true`, the response will be formatted as valid GeoJSON.  Otherwise, it will be wrapped within `data` along with a `status` property.  
    Default: `false`

+ Response 200 (application/json)
    + Attributes (object)
      + status: success (string)
      + data (GeoJson)

### Get Zips Info [GET /api/zips/info{?q}{&file}]
Get all the information about a given ZipCode

+ Parameters
    + q (string) - comma-delimited list of Zipcodes
    + file (boolean, optional) - if `true`, the response will be downloaded as a file.  
      Default: `false`
      
+ Response 200 (application/json)
    + Attributes (object)
        + status: success (string)
        + data (FullInfo)

### Get Zips Reverse Geocode [GET /api/zips/reverse_geocode{?lat}{&long}{&add_geojson}]
Returns the Zipcode information and boundary 

+ Parameters
  + lat (string) - Latitude
  + long (string) - Longitude
  + add_geojson (boolean, optional) - Include Geojson into the response.  This Geojson will have the zipcode's full demographic information as well.  
  Default: `false`

+ Response 200 (application/json)
    + Attributes (object)
      + status: success (string)
      + data (object)
        + results (array[CityResult])
        + geojson (object)
          + properties (FullInfo)
          + geometry (Polygon)
          
# Data Structures
## CityResult (object)
+ full: Chicago, IL (string)
+ city: Chicago (string)
+ state: IL (string)

## FullInfo (object)
+ PrimaryRecord: P (string)
+ SFDU: 3795 (string)
+ CongressionalDistrict: 05|09 (string)
+ CountyFIPS: 031 (string)
+ HawaiianPopulation: 73 (string)
+ Elevation: 596 (string)
+ ClassificationCode: B5  (string)
+ ALAND10: 5632040 (number)
+ CBSADivisionPopulation: 7262718 (string)
+ INTPTLON10: 087.6542721 (string)
+ MedicareCBSAType: Metro (string)
+ GrowthIncreaseNumber: 0 (string)
+ StateANSI: 17 (string)
+ UniqueZIPName: 13212 (string)
+ DeliveryTotal: 31346 (string)
+ GrowthIncreasePercentage: 0 (string)
+ Longitude: 87.655984 (string)
+ PMSA: 1600 (string)
+ FemalePopulation: 23767 (string)
+ TimeZone: 6 (string)
+ GrowingCountiesA: 0 (string)
+ GrowingCountiesB: 0 (string)
+ PreferredLastLineKey: W12401 (string)
+ FUNCSTAT10: S (string)
+ GEOID10: 60613 (string)
+ CarrierRouteRateSortation: B (string)
+ CityType: P (string)
+ SSAStateCountyCode: 14141 (string)
+ NumberOfEmployees: 10654 (string)
+ CLASSFP10: B5 (string)
+ PMSA_Name: Chicago IL PMSA (string)
+ LandArea: 2.176 (string)
+ CityAliasCode: M (string)
+ Population: 48281 (string)
+ MSA: 1602 (string)
+ Division: East North Central (string)
+ CBSA_Name: Chicago-Naperville-Elgin IL-IN-WI (string)
+ StateFullName: Illinois (string)
+ CityAliasMixedCase: Chicago (string)
+ ZCTA5CE10: 60613 (string)
+ WhitePopulation: 39663 (string)
+ CSAName: Chicago-Naperville, IL-IN-WI (string)
+ HispanicPopulation: 4832 (string)
+ MedicareCBSAName: Chicago-Naperville-Arlington Heights, IL (string)
+ MedianAge: 31.5 (string)
+ IncomePerHousehold: 69032 (string)
+ DeliveryResidential: 29591 (string)
+ BusinessAnnualPayroll: 544449 (string)
+ CongressionalLandArea: 95.71|105.35 (string)
+ MailingName: Y (string)
+ FinanceNumber: 161542 (string)
+ CityAliasAbbreviation: CHI (string)
+ BusinessFirstQuarterPayroll: 114043 (string)
+ WaterArea: 0.43 (string)
+ DayLightSaving: Y (string)
+ CBSA_Type: Metro (string)
+ Latitude: 41.952023 (string)
+ CBSA_Div_Name: Chicago-Naperville-Arlington Heights, IL (string)
+ FacilityCode: P (string)
+ NumberOfBusinesses: 1113 (string)
+ MarketRatingAreaID: 1 (string)
+ MultiCounty: N  (string)
+ PopulationEstimate: 51488 (string)
+ AliasIntroDate: <2004-10 (string)
+ MSA_Name: Chicago-Gary-Kenosha IL-IN-WI CMSA (string)
+ CBSAPopulation: 9461105 (string)
+ City: CHICAGO (string)
+ MedianAgeMale: 31.9 (string)
+ BoxCount: 178 (string)
+ CBSA_Div: 16974 (string)
+ DeliveryBusiness: 1291 (string)
+ State: IL (string)
+ AreaCode: 773 (string)
+ Region: Midwest (string)
+ ZIPIntroDate: <2004-10 (string)
+ HouseholdsPerZipCode: 27476 (string)
+ MedicareCBSACode: 16974 (string)
+ BlackPopulation: 4113 (string)
+ County: COOK (string)
+ PersonsPerHousehold: 1.74 (string)
+ MFDU: 25711 (string)
+ OtherPopulation: 2008 (string)
+ CSA: 176 (string)
+ CityMixedCase: Chicago (string)
+ CountyANSI: 031 (string)
+ BusinessEmploymentFlag: T  (string)
+ StateFIPS: 17 (string)
+ CityDeliveryIndicator: Y (string)
+ AWATER10: 1114040 (number)
+ GrowthRank: 0 (string)
+ MedianAgeFemale: 31.1 (string)
+ ZipCode: 60613 (string)
+ MalePopulation: 24514 (string)
+ IndianPopulation: 351 (string)
+ CityStateKey: W12401 (string)
+ MTFCC10: G6350 (string)
+ INTPTLAT10: +41.9569485 (string)
+ AsianPopulation: 3315 (string)
+ CBSA: 16980 (string)
+ AverageHouseValue: 309800 (string)
+ CityAliasName: CHICAGO (string)

## GeoJson (object)
+ type: FeatureCollection (string)
+ features (array[Boundary]) 

## Boundary (object)
+ type: Feature (string)
+ property (object)
  + ZipCode: 43451 (string)
  + CityMixedCase: Portage (string)
  + State: OH (string)
+ geometry (object)
  - coordinates (array[Polygon])

## Polygon (array)
+ coordinates (array)
  + 83.674464 (number)
  + 41.331119 (number)
