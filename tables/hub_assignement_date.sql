CREATE TABLE hub_assignment_date
(
    id SERIAL PRIMARY KEY,
    starts_at TIMESTAMP NOT NULL,
    ends_at TIMESTAMP NOT NULL,
    patient_id INT NOT NULL,
    hub_id INT NOT NULL
);