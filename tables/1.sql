-- getAnalysisHR
SELECT
    chm.hr,
    chm."time"
FROM
    patient AS p
        INNER JOIN
    hub_assignment_date AS had ON had.patient_id = p.id
        AND had.starts_at AT TIME ZONE 'UTC-1' => :dateTimeFrom
        AND had.ends_at AT TIME ZONE 'UTC-1' <= :dateTimeTo
        INNER JOIN
    e4l_id_conv AS h ON h.id = had.hub_id
        INNER JOIN
    chair_measurements AS chm ON chm.host = h.hub
        AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
ORDER BY
    chm.id DESC;

-- getCurrentHR
SELECT
    chm.hr
FROM
    patient AS p
        INNER JOIN
    hub_assignment_date AS had ON had.patient_id = p.id
        AND had.ends_at AT TIME ZONE 'UTC-1' <= NOW()
        INNER JOIN
    e4l_id_conv AS h ON h.id = had.hub_id
        INNER JOIN
    chair_measurements AS chm ON chm.host = h.hub
        AND chm."time" >= NOW() AT TIME ZONE 'UTC-1' - INTERVAL '2 minutes'
WHERE
        p.id = :patientId
ORDER BY
    chm.id DESC
LIMIT 1;

-- getMinimumHR
SELECT
    chm.hr
FROM
    patient AS p
        INNER JOIN
    hub_assignment_date AS had ON had.patient_id = p.id
        AND had.ends_at AT TIME ZONE 'UTC-1' <= NOW()
        INNER JOIN
    e4l_id_conv AS h ON h.id = had.hub_id
        INNER JOIN
    chair_measurements AS chm ON chm.host = h.hub
        AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
WHERE
        p.id = :patientId
ORDER BY
    chm.hr
LIMIT 1;