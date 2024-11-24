#!/bin/bash

# Insert data into the metadata table
docker compose exec mysql mysql -urcmwa_user -psecret_password rcmwa_db -e "
INSERT INTO metadata (dataset_name, description, keywords, creator, file_format, version, tags) VALUES
('Climate Data', 'Temperature and rainfall records', 'weather, environment', 'John Doe', 'CSV', '1.0', 'environment'),
('Healthcare Analytics', 'Patient health records', 'healthcare, medical', 'Jane Smith', 'JSON', '2.0', 'healthcare');
"
