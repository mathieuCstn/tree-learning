<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241111182331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id SERIAL NOT NULL, rncp VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE address (id SERIAL NOT NULL, user_account_id INT DEFAULT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D4E6F813C0C9956 ON address (user_account_id)');
        $this->addSql('CREATE TABLE assessment_session (id SERIAL NOT NULL, user_account_id INT DEFAULT NULL, quiz_id INT DEFAULT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7ABA441A3C0C9956 ON assessment_session (user_account_id)');
        $this->addSql('CREATE INDEX IDX_7ABA441A853CD175 ON assessment_session (quiz_id)');
        $this->addSql('COMMENT ON COLUMN assessment_session.completed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE chapter (id SERIAL NOT NULL, module_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F981B52EAFC2B591 ON chapter (module_id)');
        $this->addSql('CREATE TABLE choice (id SERIAL NOT NULL, question_id INT DEFAULT NULL, content TEXT NOT NULL, is_correct BOOLEAN NOT NULL, feedback TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C1AB5A921E27F6BF ON choice (question_id)');
        $this->addSql('CREATE TABLE course (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, duration SMALLINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE course_module (course_id INT NOT NULL, module_id INT NOT NULL, PRIMARY KEY(course_id, module_id))');
        $this->addSql('CREATE INDEX IDX_A21CE765591CC992 ON course_module (course_id)');
        $this->addSql('CREATE INDEX IDX_A21CE765AFC2B591 ON course_module (module_id)');
        $this->addSql('CREATE TABLE degree (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, level VARCHAR(255) DEFAULT NULL, speciality VARCHAR(255) DEFAULT NULL, obtained_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN degree.obtained_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE education (id SERIAL NOT NULL, address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DB0A5ED2F5B7AF75 ON education (address_id)');
        $this->addSql('CREATE TABLE education_course (education_id INT NOT NULL, course_id INT NOT NULL, PRIMARY KEY(education_id, course_id))');
        $this->addSql('CREATE INDEX IDX_5E90D5E82CA1BD71 ON education_course (education_id)');
        $this->addSql('CREATE INDEX IDX_5E90D5E8591CC992 ON education_course (course_id)');
        $this->addSql('CREATE TABLE module (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, content TEXT DEFAULT NULL, repository_link VARCHAR(255) DEFAULT NULL, module_order SMALLINT DEFAULT NULL, duration SMALLINT DEFAULT NULL, is_updated BOOLEAN DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN module.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN module.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE planning (id SERIAL NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE question (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE quiz (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN quiz.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE quiz_question (quiz_id INT NOT NULL, question_id INT NOT NULL, PRIMARY KEY(quiz_id, question_id))');
        $this->addSql('CREATE INDEX IDX_6033B00B853CD175 ON quiz_question (quiz_id)');
        $this->addSql('CREATE INDEX IDX_6033B00B1E27F6BF ON quiz_question (question_id)');
        $this->addSql('CREATE TABLE quiz_skill (quiz_id INT NOT NULL, skill_id INT NOT NULL, PRIMARY KEY(quiz_id, skill_id))');
        $this->addSql('CREATE INDEX IDX_A24E9DF7853CD175 ON quiz_skill (quiz_id)');
        $this->addSql('CREATE INDEX IDX_A24E9DF75585C142 ON quiz_skill (skill_id)');
        $this->addSql('CREATE TABLE raiting (id SERIAL NOT NULL, supervisor_id INT DEFAULT NULL, module_id INT DEFAULT NULL, score SMALLINT DEFAULT NULL, comment TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3AE2A20919E9AC5F ON raiting (supervisor_id)');
        $this->addSql('CREATE INDEX IDX_3AE2A209AFC2B591 ON raiting (module_id)');
        $this->addSql('COMMENT ON COLUMN raiting.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN raiting.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE session_quiz_choice (id SERIAL NOT NULL, assessmentsession_id INT DEFAULT NULL, choice_id INT DEFAULT NULL, score SMALLINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D0B6B4BCFED2BE2E ON session_quiz_choice (assessmentsession_id)');
        $this->addSql('CREATE INDEX IDX_D0B6B4BC998666D1 ON session_quiz_choice (choice_id)');
        $this->addSql('CREATE TABLE skill (id SERIAL NOT NULL, activity_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E3DE47781C06096 ON skill (activity_id)');
        $this->addSql('CREATE TABLE skill_course (skill_id INT NOT NULL, course_id INT NOT NULL, PRIMARY KEY(skill_id, course_id))');
        $this->addSql('CREATE INDEX IDX_39D43BAD5585C142 ON skill_course (skill_id)');
        $this->addSql('CREATE INDEX IDX_39D43BAD591CC992 ON skill_course (course_id)');
        $this->addSql('CREATE TABLE title (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE title_education (title_id INT NOT NULL, education_id INT NOT NULL, PRIMARY KEY(title_id, education_id))');
        $this->addSql('CREATE INDEX IDX_7AF25619A9F87BD ON title_education (title_id)');
        $this->addSql('CREATE INDEX IDX_7AF256192CA1BD71 ON title_education (education_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, roles JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_degree (user_id INT NOT NULL, degree_id INT NOT NULL, PRIMARY KEY(user_id, degree_id))');
        $this->addSql('CREATE INDEX IDX_C2F1765EA76ED395 ON user_degree (user_id)');
        $this->addSql('CREATE INDEX IDX_C2F1765EB35C5756 ON user_degree (degree_id)');
        $this->addSql('CREATE TABLE user_skill (user_id INT NOT NULL, skill_id INT NOT NULL, PRIMARY KEY(user_id, skill_id))');
        $this->addSql('CREATE INDEX IDX_BCFF1F2FA76ED395 ON user_skill (user_id)');
        $this->addSql('CREATE INDEX IDX_BCFF1F2F5585C142 ON user_skill (skill_id)');
        $this->addSql('CREATE TABLE user_detail (id SERIAL NOT NULL, account_id INT DEFAULT NULL, cv VARCHAR(255) DEFAULT NULL, bio TEXT DEFAULT NULL, github_link VARCHAR(255) DEFAULT NULL, personal_website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4B5464AE9B6B5FBA ON user_detail (account_id)');
        $this->addSql('CREATE TABLE user_module_planning (id SERIAL NOT NULL, module_id INT DEFAULT NULL, user_teacher_id INT DEFAULT NULL, planning_id INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A2850087AFC2B591 ON user_module_planning (module_id)');
        $this->addSql('CREATE INDEX IDX_A2850087E6E7B8F1 ON user_module_planning (user_teacher_id)');
        $this->addSql('CREATE INDEX IDX_A28500873D865311 ON user_module_planning (planning_id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F813C0C9956 FOREIGN KEY (user_account_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assessment_session ADD CONSTRAINT FK_7ABA441A3C0C9956 FOREIGN KEY (user_account_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assessment_session ADD CONSTRAINT FK_7ABA441A853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52EAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE choice ADD CONSTRAINT FK_C1AB5A921E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_module ADD CONSTRAINT FK_A21CE765591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_module ADD CONSTRAINT FK_A21CE765AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED2F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE education_course ADD CONSTRAINT FK_5E90D5E82CA1BD71 FOREIGN KEY (education_id) REFERENCES education (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE education_course ADD CONSTRAINT FK_5E90D5E8591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00B1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quiz_skill ADD CONSTRAINT FK_A24E9DF7853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quiz_skill ADD CONSTRAINT FK_A24E9DF75585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE raiting ADD CONSTRAINT FK_3AE2A20919E9AC5F FOREIGN KEY (supervisor_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE raiting ADD CONSTRAINT FK_3AE2A209AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session_quiz_choice ADD CONSTRAINT FK_D0B6B4BCFED2BE2E FOREIGN KEY (assessmentsession_id) REFERENCES assessment_session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session_quiz_choice ADD CONSTRAINT FK_D0B6B4BC998666D1 FOREIGN KEY (choice_id) REFERENCES choice (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE47781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skill_course ADD CONSTRAINT FK_39D43BAD5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skill_course ADD CONSTRAINT FK_39D43BAD591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE title_education ADD CONSTRAINT FK_7AF25619A9F87BD FOREIGN KEY (title_id) REFERENCES title (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE title_education ADD CONSTRAINT FK_7AF256192CA1BD71 FOREIGN KEY (education_id) REFERENCES education (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_degree ADD CONSTRAINT FK_C2F1765EA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_degree ADD CONSTRAINT FK_C2F1765EB35C5756 FOREIGN KEY (degree_id) REFERENCES degree (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2FA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2F5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_detail ADD CONSTRAINT FK_4B5464AE9B6B5FBA FOREIGN KEY (account_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_module_planning ADD CONSTRAINT FK_A2850087AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_module_planning ADD CONSTRAINT FK_A2850087E6E7B8F1 FOREIGN KEY (user_teacher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_module_planning ADD CONSTRAINT FK_A28500873D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE address DROP CONSTRAINT FK_D4E6F813C0C9956');
        $this->addSql('ALTER TABLE assessment_session DROP CONSTRAINT FK_7ABA441A3C0C9956');
        $this->addSql('ALTER TABLE assessment_session DROP CONSTRAINT FK_7ABA441A853CD175');
        $this->addSql('ALTER TABLE chapter DROP CONSTRAINT FK_F981B52EAFC2B591');
        $this->addSql('ALTER TABLE choice DROP CONSTRAINT FK_C1AB5A921E27F6BF');
        $this->addSql('ALTER TABLE course_module DROP CONSTRAINT FK_A21CE765591CC992');
        $this->addSql('ALTER TABLE course_module DROP CONSTRAINT FK_A21CE765AFC2B591');
        $this->addSql('ALTER TABLE education DROP CONSTRAINT FK_DB0A5ED2F5B7AF75');
        $this->addSql('ALTER TABLE education_course DROP CONSTRAINT FK_5E90D5E82CA1BD71');
        $this->addSql('ALTER TABLE education_course DROP CONSTRAINT FK_5E90D5E8591CC992');
        $this->addSql('ALTER TABLE quiz_question DROP CONSTRAINT FK_6033B00B853CD175');
        $this->addSql('ALTER TABLE quiz_question DROP CONSTRAINT FK_6033B00B1E27F6BF');
        $this->addSql('ALTER TABLE quiz_skill DROP CONSTRAINT FK_A24E9DF7853CD175');
        $this->addSql('ALTER TABLE quiz_skill DROP CONSTRAINT FK_A24E9DF75585C142');
        $this->addSql('ALTER TABLE raiting DROP CONSTRAINT FK_3AE2A20919E9AC5F');
        $this->addSql('ALTER TABLE raiting DROP CONSTRAINT FK_3AE2A209AFC2B591');
        $this->addSql('ALTER TABLE session_quiz_choice DROP CONSTRAINT FK_D0B6B4BCFED2BE2E');
        $this->addSql('ALTER TABLE session_quiz_choice DROP CONSTRAINT FK_D0B6B4BC998666D1');
        $this->addSql('ALTER TABLE skill DROP CONSTRAINT FK_5E3DE47781C06096');
        $this->addSql('ALTER TABLE skill_course DROP CONSTRAINT FK_39D43BAD5585C142');
        $this->addSql('ALTER TABLE skill_course DROP CONSTRAINT FK_39D43BAD591CC992');
        $this->addSql('ALTER TABLE title_education DROP CONSTRAINT FK_7AF25619A9F87BD');
        $this->addSql('ALTER TABLE title_education DROP CONSTRAINT FK_7AF256192CA1BD71');
        $this->addSql('ALTER TABLE user_degree DROP CONSTRAINT FK_C2F1765EA76ED395');
        $this->addSql('ALTER TABLE user_degree DROP CONSTRAINT FK_C2F1765EB35C5756');
        $this->addSql('ALTER TABLE user_skill DROP CONSTRAINT FK_BCFF1F2FA76ED395');
        $this->addSql('ALTER TABLE user_skill DROP CONSTRAINT FK_BCFF1F2F5585C142');
        $this->addSql('ALTER TABLE user_detail DROP CONSTRAINT FK_4B5464AE9B6B5FBA');
        $this->addSql('ALTER TABLE user_module_planning DROP CONSTRAINT FK_A2850087AFC2B591');
        $this->addSql('ALTER TABLE user_module_planning DROP CONSTRAINT FK_A2850087E6E7B8F1');
        $this->addSql('ALTER TABLE user_module_planning DROP CONSTRAINT FK_A28500873D865311');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE assessment_session');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE choice');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_module');
        $this->addSql('DROP TABLE degree');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE education_course');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_question');
        $this->addSql('DROP TABLE quiz_skill');
        $this->addSql('DROP TABLE raiting');
        $this->addSql('DROP TABLE session_quiz_choice');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_course');
        $this->addSql('DROP TABLE title');
        $this->addSql('DROP TABLE title_education');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_degree');
        $this->addSql('DROP TABLE user_skill');
        $this->addSql('DROP TABLE user_detail');
        $this->addSql('DROP TABLE user_module_planning');
    }
}
