CREATE DATABASE IF NOT EXISTS avsa_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE avsa_db;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(30) DEFAULT NULL,
    country VARCHAR(100) DEFAULT NULL,
    role_id INT DEFAULT NULL,
    status ENUM('active', 'inactive', 'pending') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL,
    INDEX idx_users_email (email),
    INDEX idx_users_role (role_id)
);

CREATE TABLE user_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    UNIQUE KEY uq_user_role (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    icon VARCHAR(100) DEFAULT NULL,
    image VARCHAR(255) DEFAULT NULL,
    description TEXT NOT NULL,
    objectives TEXT,
    activities TEXT,
    target_beneficiaries TEXT,
    results TEXT,
    status ENUM('draft','published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_programs_slug (slug)
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    category VARCHAR(100) NOT NULL,
    location VARCHAR(200) NOT NULL,
    country VARCHAR(100) NOT NULL,
    start_date DATE,
    end_date DATE,
    description TEXT NOT NULL,
    objectives TEXT,
    target_beneficiaries TEXT,
    budget DECIMAL(15,2) DEFAULT 0.00,
    funding_source VARCHAR(200) DEFAULT NULL,
    status ENUM('Upcoming','Ongoing','Completed') NOT NULL DEFAULT 'Ongoing',
    progress_percentage INT NOT NULL DEFAULT 0,
    image VARCHAR(255) DEFAULT NULL,
    gallery JSON DEFAULT NULL,
    project_updates TEXT,
    results TEXT,
    impact_statistics JSON DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_projects_status (status),
    INDEX idx_projects_country (country)
);

CREATE TABLE project_updates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    update_date DATE NOT NULL,
    images JSON DEFAULT NULL,
    videos JSON DEFAULT NULL,
    author VARCHAR(150) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    INDEX idx_project_updates_project (project_id)
);

CREATE TABLE impact_metrics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    metric_key VARCHAR(100) NOT NULL UNIQUE,
    metric_label VARCHAR(150) NOT NULL,
    value VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_impact_key (metric_key)
);

CREATE TABLE stories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(250) NOT NULL,
    slug VARCHAR(250) NOT NULL UNIQUE,
    featured_image VARCHAR(255) DEFAULT NULL,
    author VARCHAR(150) NOT NULL,
    story_date DATE NOT NULL,
    category ENUM('News','Success Stories','Health','Education','Community','Events','Announcements') NOT NULL,
    content LONGTEXT NOT NULL,
    tags VARCHAR(255) DEFAULT NULL,
    related_projects TEXT,
    status ENUM('draft','published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_stories_category (category)
);

CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(250) NOT NULL,
    slug VARCHAR(250) NOT NULL UNIQUE,
    featured_image VARCHAR(255) DEFAULT NULL,
    author VARCHAR(150) NOT NULL,
    news_date DATE NOT NULL,
    category ENUM('News','Success Stories','Health','Education','Community','Events','Announcements') NOT NULL,
    content LONGTEXT NOT NULL,
    tags VARCHAR(255) DEFAULT NULL,
    related_projects TEXT,
    status ENUM('draft','published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    category ENUM('Children','Health','Education','Community','Events','Projects','Volunteers','Other') NOT NULL DEFAULT 'Other',
    file_path VARCHAR(255) NOT NULL,
    media_type ENUM('image','video') NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_gallery_category (category)
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(250) NOT NULL,
    slug VARCHAR(250) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    event_date DATETIME NOT NULL,
    venue VARCHAR(200) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    status ENUM('draft','published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_name VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    country VARCHAR(100) DEFAULT NULL,
    amount DECIMAL(12,2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'USD',
    donation_type ENUM('One-time','Monthly') NOT NULL DEFAULT 'One-time',
    message TEXT,
    status ENUM('Pending','Successful','Failed','Refunded') NOT NULL DEFAULT 'Pending',
    payment_reference VARCHAR(200) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_donations_status (status)
);

CREATE TABLE volunteers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    country VARCHAR(100) DEFAULT NULL,
    area_of_interest VARCHAR(150) DEFAULT NULL,
    skills TEXT,
    message TEXT,
    status ENUM('new','reviewed','approved','rejected') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_volunteers_email (email)
);

CREATE TABLE partners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    organization_type VARCHAR(150) DEFAULT NULL,
    contact_person VARCHAR(200) DEFAULT NULL,
    email VARCHAR(200) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    description TEXT,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new','read','replied','closed') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_contact_status (status)
);

CREATE TABLE newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    status ENUM('active','unsubscribed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_newsletter_email (email)
);

CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    role VARCHAR(150) DEFAULT NULL,
    quote TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL,
    action VARCHAR(200) NOT NULL,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_audit_user (user_id)
);

INSERT INTO roles (name, description) VALUES
('Super Admin', 'Full platform control'),
('Administrator', 'Manage content and users'),
('Editor', 'Manage stories and pages'),
('Finance', 'Manage donations and reports'),
('Volunteer Manager', 'Manage volunteers and outreach');

INSERT INTO site_settings (setting_key, setting_value, description) VALUES
('site_name', 'AVSA', 'Website name'),
('site_slogan', 'Supporting Lives. Restoring Dignity. Building Hope.', 'Main slogan'),
('primary_color', '#103875', 'Primary AVSA navy color'),
('secondary_color', '#176b32', 'Secondary AVSA green color'),
('contact_email', 'hello@avsa.org', 'Primary contact email'),
('contact_phone', '+250 788 000 000', 'Primary contact phone'),
('address', 'Kigali, Rwanda', 'Main office address'),
('app_url', 'http://localhost/AVSA', 'Application URL'),
('facebook_url', '#', 'Facebook link'),
('instagram_url', '#', 'Instagram link'),
('linkedin_url', '#', 'LinkedIn link'),
('youtube_url', '#', 'YouTube link'),
('x_url', '#', 'X/Twitter link');

INSERT INTO impact_metrics (metric_key, metric_label, value, description) VALUES
('children_supported', 'Children Supported', '10,000+', 'Children supported through health and protection programmes'),
('families_reached', 'Families Reached', '5,000+', 'Families supported with food and livelihoods assistance'),
('communities_served', 'Communities Served', '50+', 'Communities supported by AVSA programmes'),
('projects_completed', 'Projects Completed', '25+', 'Completed community development and support projects'),
('volunteers', 'Volunteers', '1,200+', 'Active and engaged volunteers'),
('partners', 'Partners', '40+', 'Strategic partners and donors');

INSERT INTO programs (title, slug, icon, image, description, objectives, activities, target_beneficiaries, results, status) VALUES
('Child Health & Wellbeing', 'child-health-wellbeing', 'fa-heart', 'https://images.unsplash.com/photo-1542810634-71277d95dcbb', 'Comprehensive health support for infants, children and adolescents.', 'Improve child health outcomes and access to care.', 'Clinic screenings, immunization awareness, nutrition support, follow-up care.', 'Children under 18, caregivers, community health volunteers.', 'Improved access to preventive care and family health guidance.', 'published'),
('Orphans & Vulnerable Children', 'orphans-vulnerable-children', 'fa-child', 'https://images.unsplash.com/photo-1509099836639-18ba02c6f2d7', 'Safe care and protective support for children facing abandonment and hardship.', 'Strengthen safety, education, and psychosocial stability for vulnerable children.', 'Home tracing, school support, care plans, counselling, protection referrals.', 'Children without caregivers and at-risk youth.', 'More children placed in safer support networks.', 'published'),
('Poverty & Family Support', 'poverty-family-support', 'fa-house', 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6', 'Economic resilience support for poor households and families in crisis.', 'Reduce household vulnerability and improve livelihoods.', 'Cash transfers, food security support, livelihoods coaching, household assessments.', 'Low-income households and families in extreme poverty.', 'Improved household resilience and food security.', 'published'),
('Education & Skills Development', 'education-skills-development', 'fa-graduation-cap', 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b', 'Education, digital access, and skills pathways for youth and adults.', 'Increase learning opportunities and economic readiness.', 'School fee support, mentoring, digital learning, vocational training.', 'Students, out-of-school youth, women and men in need.', 'Greater educational attendance and livelihood readiness.', 'published'),
('Support for Marginalized Communities', 'support-for-marginalized-communities', 'fa-users', 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b', 'Inclusive community support for groups often left behind by development.', 'Promote equity, agency, and inclusion for marginalized groups.', 'Community outreach, inclusion advocacy, safe spaces, public education.', 'Marginalized households, persons with disabilities, women and youth.', 'Increased trust, inclusion, and service access in communities.', 'published'),
('Emergency & Community Assistance', 'emergency-community-assistance', 'fa-hands-helping', 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b', 'Rapid humanitarian support during crises and emergencies.', 'Provide immediate relief and community stabilization in urgent situations.', 'Emergency response, referral support, supply distribution, recovery planning.', 'Families and communities affected by shocks or crises.', 'Faster response and improved community stability.', 'published');

INSERT INTO projects (title, slug, category, location, country, start_date, end_date, description, objectives, target_beneficiaries, budget, funding_source, status, progress_percentage, image, impact_statistics) VALUES
('Rural Health Access Initiative', 'rural-health-access-initiative', 'Health', 'Gisagara', 'Rwanda', '2024-01-01', '2025-12-31', 'Strengthening community health access through mobile clinics and outreach.', 'Expand preventive care, referral pathways, and community follow-up in underserved areas.', 'Children, pregnant women, older adults and caregivers.', 150000.00, 'UNICEF', 'Ongoing', 72, 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289', '{"beneficiaries": "3,200", "healthVisits": "8,400"}'),
('Hope for Every Child', 'hope-for-every-child', 'Child Protection', 'Kigali', 'Rwanda', '2023-05-01', '2024-08-31', 'Protecting vulnerable children through family support and school reintegration.', 'Reduce risk and strengthen care systems for vulnerable children.', 'Orphaned and at-risk children.', 90000.00, 'Private donors', 'Completed', 100, 'https://images.unsplash.com/photo-1516627145497-ae6968895b74', '{"beneficiaries": "1,500", "schoolRetention": "94%"}'),
('Women and Youth Livelihood Recovery', 'women-youth-livelihood-recovery', 'Poverty Reduction', 'Byumba', 'Rwanda', '2024-03-15', '2026-02-28', 'Supporting livelihoods recovery for women and youth in vulnerable communities.', 'Increase income stability and household resilience through entrepreneurship and training.', 'Women, youth and households experiencing economic shocks.', 220000.00, 'International partners', 'Ongoing', 58, 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f', '{"beneficiaries": "2,400", "incomeGrowth": "38%"}');

INSERT INTO testimonials (name, role, quote, image) VALUES
('Aline', 'Parent', 'AVSA helped us access health care and regained hope for our family.', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2'),
('Joseph', 'Volunteer', 'Volunteering with AVSA made me feel part of a real community transformation journey.', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e');
