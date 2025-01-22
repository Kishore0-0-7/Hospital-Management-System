CREATE TABLE IF NOT EXISTS patient_health_details (
    pid int NOT NULL,
    age int,
    blood_group varchar(5),
    weight decimal(5,2),
    height decimal(5,2),
    medical_conditions text,
    allergies text,
    current_medications text,
    family_history text,
    emergency_contact varchar(100),
    emergency_contact_phone varchar(15),
    last_updated timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (pid),
    FOREIGN KEY (pid) REFERENCES patreg(pid)
);
