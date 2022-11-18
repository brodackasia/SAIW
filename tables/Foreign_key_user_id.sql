ALTER TABLE
    e4l_id_conv
ADD
    user_id INT;

ALTER TABLE
    e4l_id_conv
ADD CONSTRAINT
    e4l_id_conv_user_id_fk
FOREIGN KEY (user_id)
    REFERENCES "user";