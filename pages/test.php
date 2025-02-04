<?php
$osmId = 3422189698;
$url = 'https://overpass-api.de/api/interpreter';
$query = "[out:json];
(
  node($osmId);
  way($osmId);
  relation($osmId);
);
out body;
>;
out skel qt;";

$response = file_get_contents($url . '?data=' . urlencode($query));
$data = json_decode($response, true);

if (isset($data['elements'])) {
    foreach ($data['elements'] as $element) {
        $info = [
            "geo_point_2d" => [
                "lon" => $element['lon'],
                "lat" => $element['lat']
            ],
            "geo_shape" => [
                "type" => "Feature",
                "geometry" => [
                    "coordinates" => [$element['lon'], $element['lat']],
                    "type" => "Point"
                ],
                "properties" => []
            ],
            "osm_id" => "node/$osmId",
            "type" => $element['tags']['amenity'] ?? null,
            "name" => $element['tags']['name'] ?? null,
            "operator" => $element['tags']['operator'] ?? null,
            "brand" => $element['tags']['brand'] ?? null,
            "opening_hours" => $element['tags']['opening_hours'] ?? null,
            "wheelchair" => $element['tags']['wheelchair'] ?? null,
            "cuisine" => $element['tags']['cuisine'] ?? null,
            "vegetarian" => $element['tags']['diet:vegetarian'] ?? null,
            "vegan" => $element['tags']['diet:vegan'] ?? null,
            "delivery" => $element['tags']['delivery'] ?? null,
            "takeaway" => $element['tags']['takeaway'] ?? null,
            "internet_access" => $element['tags']['internet_access'] ?? null,
            "stars" => $element['tags']['stars'] ?? null,
            "capacity" => $element['tags']['capacity'] ?? null,
            "drive_through" => $element['tags']['drive_through'] ?? null,
            "wikidata" => $element['tags']['wikidata'] ?? null,
            "brand_wikidata" => $element['tags']['brand:wikidata'] ?? null,
            "siret" => $element['tags']['ref:FR:SIRET'] ?? null,
            "phone" => $element['tags']['phone'] ?? null,
            "website" => $element['tags']['website'] ?? null,
            "facebook" => $element['tags']['contact:facebook'] ?? null,
            "smoking" => $element['tags']['smoking'] ?? null,
            "com_insee" => $element['tags']['ref:FR:INSEE'] ?? null,
            "com_nom" => $element['tags']['is_in:city'] ?? null,
            "region" => $element['tags']['is_in:region'] ?? null,
            "code_region" => $element['tags']['is_in:region_code'] ?? null,
            "departement" => $element['tags']['is_in:departement'] ?? null,
            "code_departement" => $element['tags']['is_in:departement_code'] ?? null,
            "commune" => $element['tags']['is_in:commune'] ?? null,
            "code_commune" => $element['tags']['is_in:commune_code'] ?? null,
            "osm_edit" => "https://www.openstreetmap.org/edit?node=$osmId"
        ];

        // Afficher les informations
        echo "<pre>";
        print_r($info);
        echo "</pre>";
    }
} else {
    echo "Erreur: Aucune information trouvée";
}
?>
