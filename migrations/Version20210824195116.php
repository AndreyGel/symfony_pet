<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210824195116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE completed_task (id BIGSERIAL NOT NULL, student_id BIGINT DEFAULT NULL, task_id BIGINT DEFAULT NULL, score INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX completed_task__student_id__ind ON completed_task (student_id)');
        $this->addSql('CREATE INDEX completed_task__task_id__ind ON completed_task (task_id)');
        $this->addSql('CREATE TABLE "module" (id BIGSERIAL NOT NULL, parent_id BIGINT DEFAULT NULL, tree_root BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, "left" INT NOT NULL, "right" INT NOT NULL, lvl INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX module__parent_id__ind ON "module" (parent_id)');
        $this->addSql('CREATE INDEX module__tree_root__ind ON "module" (tree_root)');
        $this->addSql('CREATE TABLE skill (id BIGSERIAL NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE skill_task (id BIGSERIAL NOT NULL, skill_id BIGINT DEFAULT NULL, task_id BIGINT DEFAULT NULL, point INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX skill_task__skill_id__ind ON skill_task (skill_id)');
        $this->addSql('CREATE INDEX skill_task__task_id__ind ON skill_task (task_id)');
        $this->addSql('CREATE TABLE student (id BIGSERIAL NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX student__email_uniq ON student (email)');
        $this->addSql('CREATE TABLE student_skill (id BIGSERIAL NOT NULL, skill_id BIGINT DEFAULT NULL, student_id BIGINT DEFAULT NULL, point INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX student_skill__skill_id__ind ON student_skill (skill_id)');
        $this->addSql('CREATE INDEX student_skill__student_id__ind ON student_skill (student_id)');
        $this->addSql('CREATE TABLE task (id BIGSERIAL NOT NULL, module_id BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX task__module_id__ind ON task (module_id)');
        $this->addSql('CREATE UNIQUE INDEX task__name_uniq ON task (name)');
        $this->addSql('ALTER TABLE completed_task ADD CONSTRAINT fk_completed_task__student_id FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE completed_task ADD CONSTRAINT fk_completed_task__task_id FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "module" ADD CONSTRAINT fk_module__parent_id FOREIGN KEY (parent_id) REFERENCES "module" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "module" ADD CONSTRAINT fk_module__tree_root FOREIGN KEY (tree_root) REFERENCES "module" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skill_task ADD CONSTRAINT fk_skill_task__skill_id FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skill_task ADD CONSTRAINT fk_skill_task__task_id FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student_skill ADD CONSTRAINT fk_student_skill__skill_id FOREIGN KEY (skill_id) REFERENCES skill (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student_skill ADD CONSTRAINT fk_student_skill__student_id FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT fk_task__module_id FOREIGN KEY (module_id) REFERENCES "module" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "module" DROP CONSTRAINT fk_module__parent_id');
        $this->addSql('ALTER TABLE "module" DROP CONSTRAINT fk_module__tree_root');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT fk_task__module_id');
        $this->addSql('ALTER TABLE skill_task DROP CONSTRAINT fk_skill_task__skill_id');
        $this->addSql('ALTER TABLE skill_task DROP CONSTRAINT fk_skill_task__task_id');
        $this->addSql('ALTER TABLE completed_task DROP CONSTRAINT fk_completed_task__student_id');
        $this->addSql('ALTER TABLE completed_task DROP CONSTRAINT fk_completed_task__task_id');
        $this->addSql('ALTER TABLE student_skill DROP CONSTRAINT fk_student_skill__skill_id');
        $this->addSql('ALTER TABLE student_skill DROP CONSTRAINT fk_student_skill__student_id');
        $this->addSql('DROP TABLE completed_task');
        $this->addSql('DROP TABLE "module"');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_task');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_skill');
        $this->addSql('DROP TABLE task');
    }
}
