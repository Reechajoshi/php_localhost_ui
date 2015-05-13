-- Localhost system database system

-- Table strucutre for table `users`
CREATE TABLE `users` (
	user_id VARCHAR(50) PRIMARY KEY DEFAULT '',
	username VARCHAR(100) NOT NULL DEFAULT '',
	password VARCHAR(100) NOT NULL DEFAULT 'secret'
) Engine=InnoDB; 

