<?php
    $errors = array();
    $response["success"] = true;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST["name"];
        $nameLen = mb_strlen($name);

        $teacher = $_POST["teacher"];
        $teacherLen = mb_strlen($teacher);

        $description = $_POST["description"];
        $descriptionLen = mb_strlen($description);

        $group = $_POST["group"];

        $credits = $_POST["credits"];

        if (!$name) {
            $errors["name"] = "Името на учебния предмет e задължително поле";
        } else if ($nameLen < 2 || $nameLen > 150) {
            $errors["name"] = "Името на учебния предмет трябва да съдържа между 2 и 150 символа включително. Вие сте въвели {$nameLen} символа.";
        }

        if (!$teacher) {
            $errors["teacher"] = "Името на преподавателя e задължително поле";
        } else if ($teacherLen < 3 || $teacherLen > 200) {
            $errors["teacher"] = "Името на преподавателя трябва да съдържа между 3 и 200 символа включително. Вие сте въвели {$teacherLen} символа.";
        }

        if (!$description) {
            $errors["description"] = "Описанието на учебния предмет е задължително поле.";
        } else if ($descriptionLen < 10) {
            $errors["description"] = "Описанието на учебния предмет трябва да съдържа поне 10 символа. Вие сте въвели {$descriptionLen} символа.";
        }

        $validGroups = ["М", "ПМ", "ОКН", "ЯКН"];
        if (!$group) {
            $errors["group"] = "Групата на предмета е задължително поле.";
        } else if (!in_array($group, $validGroups)) {
            $groupsToString = join(", ", $validGroups);
            $errors["group"] = "Въведохте невалидна група. Възможните групи са {$groupsToString}.";
        }

        if (!$credits) {
            $errors["credits"] = "Кредитите, които носи предметът, са задължително поле.";
        } else {
            $creditsNumber = (double) ($credits);
            if ($creditsNumber <= 0 || $creditsNumber !== floor($creditsNumber)) {
                $errors["credits"] = "Кредитите, които носи предметът, трябва да са цяло положително число.";
            }
        }
    }


    if (!empty($errors)) {
        $response["success"] = false;
        $response["errors"] = $errors;
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE)

?>