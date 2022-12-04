ALTER TABLE
    e4l_id_conv
ADD
    patient_id INT;

ALTER TABLE
    e4l_id_conv
ADD CONSTRAINT
    e4l_id_conv_patient_id_fk
FOREIGN KEY
    (patient_id)
REFERENCES
    "patient";


ALTER TABLE
    patient
ADD
    user_id INT;

ALTER TABLE
    patient
ADD CONSTRAINT
    patient_user_id_fk
FOREIGN KEY
    (user_id)
REFERENCES
    "user";