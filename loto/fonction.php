<?php
function selectionDonnees($fileContent, $outputFile, $annee) {
    // Ouvrir le fichier source en mode lecture ("r")
    if (($handle = fopen($fileContent, "r")) !== FALSE) {
        // Ouvrir ou créer le fichier de sortie en mode écriture ("w")
        if (($outputHandle = fopen($outputFile, "w")) !== FALSE) {
            // Parcourir chaque ligne du fichier source
            while (($data = fgetcsv($handle, 3000, ";")) !== FALSE) {
                // Vérifier que la ligne contient suffisamment de colonnes
                if (count($data) >= 12) {
                    // Si $annee est spécifié, filtrer les lignes par année
                    if ($annee === null || (isset($data[2]) && strpos($data[2], "/$annee") !== false)) {
                        // Extraire les colonnes souhaitées et les concaténer
                        $ligne = $data[2] . ";" . $data[5] . ";" . $data[6] . ";" . $data[7] . ";" . $data[8] . ";" . $data[9] . ";" . $data[10] . ";" . $data[11] . PHP_EOL;

                        // Écrire la ligne dans le fichier de sortie
                        fwrite($outputHandle, $ligne);
                    }
                }
            }

            // Fermer le fichier de sortie
            fclose($outputHandle);
        } else {
            echo "Impossible d'ouvrir le fichier de sortie : $outputFile";
        }

        // Fermer le fichier source
        fclose($handle);
    } else {
        echo "Impossible d'ouvrir le fichier source : $fileContent";
    }
}

function traiterDonnees5boules($outputFile) {
    // Tableau pour stocker les fréquences des valeurs
    $frequences = array();

    // Ouvrir le fichier en mode lecture ("r")
    if (($handle = fopen($outputFile, "r")) !== FALSE) {
        // Parcourir chaque ligne du fichier
        while (($data = fgetcsv($handle, 3000, ";")) !== FALSE) {
            // Vérifier que la ligne contient des données suffisantes
            if (count($data) > 5) {  // Vérifier qu'il y a au moins 6 colonnes
                // Parcourir les colonnes de data[1] à data[5] (colonnes 2 à 6)
                for ($i = 1; $i <= 5; $i++) {
                    // Récupérer la valeur dans la colonne
                    $valeur = $data[$i];
                    // Si la valeur est numérique ou une chaîne, on l'ajoute dans le tableau des fréquences
                    if (isset($valeur)) {
                        // Si la valeur existe déjà dans le tableau des fréquences, incrémenter, sinon l'ajouter
                        if (isset($frequences[$valeur])) {
                            $frequences[$valeur]++;
                        } else {
                            $frequences[$valeur] = 1;
                        }
                    }
                }
            }
        }

        // Fermer le fichier après traitement
        fclose($handle);

        // Trier le tableau des fréquences par ordre décroissant (du plus fréquent au moins fréquent)
        arsort($frequences);

        // Extraire les 5 premières valeurs les plus fréquentes
        return array_slice($frequences, 0, 5, true);
    } else {
        echo "Impossible d'ouvrir le fichier pour traitement : $outputFile";
    }
}

function traiterDonnees2boules($outputFile) {
    // Tableau pour stocker les fréquences des valeurs
    $frequences = array();

    // Ouvrir le fichier en mode lecture ("r")
    if (($handle = fopen($outputFile, "r")) !== FALSE) {
        // Parcourir chaque ligne du fichier
        while (($data = fgetcsv($handle, 3000, ";")) !== FALSE) {
            // Vérifier que la ligne contient des données suffisantes
            // Parcourir les colonnes data[6] et data[7] (colonnes 7 et 8)
            for ($i = 6; $i <= 7; $i++) {
                // Récupérer la valeur dans la colonne
                $valeur = $data[$i];

                // Si la valeur est définie, on l'ajoute dans le tableau des fréquences
                if (isset($valeur)) {
                    // Si la valeur existe déjà dans le tableau des fréquences, incrémenter, sinon l'ajouter
                    if (isset($frequences[$valeur])) {
                        $frequences[$valeur]++;
                    } else {
                        $frequences[$valeur] = 1;
                    }
                }
            }
        }

        // Fermer le fichier après traitement
        fclose($handle);

        // Trier le tableau des fréquences par ordre décroissant (du plus fréquent au moins fréquent)
        arsort($frequences);

        // Extraire les 5 premières valeurs les plus fréquentes
        return array_slice($frequences, 0, 2, true);
    } else {
        echo "Impossible d'ouvrir le fichier pour traitement : $outputFile";
    }
}

function extraireAnnee($outputFile) {
    // Variable pour stocker l'année la plus ancienne trouvée
    $anneeLaPlusAncienne = null;

    // Ouvrir le fichier en mode lecture ("r")
    if (($handle = fopen($outputFile, "r")) !== FALSE) {
        // Parcourir chaque ligne du fichier
        while (($data = fgetcsv($handle, 3000, ";")) !== FALSE) {
            // Vérifier que la première colonne contient une date
            if (!empty($data[0])) {
                // Extraire l'année de la colonne contenant la date
                $dateElements = explode("/", $data[0]);

                // Vérifier que le format de la date est correct
                if (count($dateElements) === 3) {
                    $annee = intval($dateElements[2]); // Convertir l'année en entier

                    // Si c'est la première année ou qu'elle est plus ancienne, mettre à jour
                    if ($anneeLaPlusAncienne === null || $annee < $anneeLaPlusAncienne) {
                        $anneeLaPlusAncienne = $annee;
                    }
                }
            }
        }

        // Fermer le fichier après traitement
        fclose($handle);
    } else {
        echo "Impossible d'ouvrir le fichier : $outputFile";
        return null;
    }

    // Retourner l'année la plus ancienne trouvée
    return $anneeLaPlusAncienne;
}
?>
