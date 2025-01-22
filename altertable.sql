ALTER TABLE prestb 
ADD COLUMN age INT,
ADD COLUMN blood_group VARCHAR(5),
ADD COLUMN height DECIMAL(5,2),
ADD COLUMN weight DECIMAL(5,2),
ADD COLUMN medical_history TEXT,
ADD COLUMN emergency_contact VARCHAR(15),
ADD COLUMN emergency_relation VARCHAR(50),
ADD COLUMN insurance_no VARCHAR(50),
ADD COLUMN insurance_provider VARCHAR(100);