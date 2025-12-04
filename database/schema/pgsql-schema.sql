
CREATE TABLE public.audit_logs (
    id uuid NOT NULL,
    entity character varying(64) NOT NULL,
    record_id uuid NOT NULL,
    action character varying(255) NOT NULL,
    user_id uuid,
    old_data jsonb,
    new_data jsonb,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT audit_logs_action_check CHECK (((action)::text = ANY ((ARRAY['create'::character varying, 'update'::character varying, 'delete'::character varying, 'login'::character varying, 'logout'::character varying])::text[])))
);



CREATE TABLE public.blocks (
    id uuid NOT NULL,
    terms_id uuid NOT NULL,
    name character varying(255) NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    mid_term character varying(8)
);



CREATE TABLE public.building (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    code character varying(255) NOT NULL,
    description text,
    total_floors integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);



CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);



CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);



CREATE TABLE public.classes (
    id uuid NOT NULL,
    level integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    rombel character varying(32) DEFAULT '1'::character varying NOT NULL,
    major_id uuid
);



CREATE TABLE public.classhistories (
    id uuid NOT NULL,
    student_id uuid CONSTRAINT classhistories_user_id_not_null NOT NULL,
    class_id uuid NOT NULL,
    terms_id uuid NOT NULL,
    block_id uuid NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);



CREATE TABLE public.companies (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    logo character varying(255),
    website character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);



CREATE TABLE public.company_relations (
    id uuid NOT NULL,
    company_id uuid NOT NULL,
    major_id uuid NOT NULL,
    partnership_type character varying(255),
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    start_date date,
    end_date date,
    document_link character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);



CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);



CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;



CREATE TABLE public.guardian_class_history (
    id uuid NOT NULL,
    teacher_id uuid,
    class_id uuid NOT NULL,
    started_at timestamp(0) without time zone,
    ended_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    block_id uuid
);



CREATE TABLE public.import_jobs (
    id uuid NOT NULL,
    type character varying(255) NOT NULL,
    entity character varying(64) NOT NULL,
    file_path text,
    status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    message text,
    created_by uuid,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT import_jobs_status_check CHECK (((status)::text = ANY ((ARRAY['pending'::character varying, 'running'::character varying, 'success'::character varying, 'failed'::character varying])::text[]))),
    CONSTRAINT import_jobs_type_check CHECK (((type)::text = ANY ((ARRAY['import'::character varying, 'export'::character varying])::text[])))
);



CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);



CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);



CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;



CREATE TABLE public.major_subject (
    id uuid NOT NULL,
    major_id uuid NOT NULL,
    subject_id uuid NOT NULL,
    notes text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);



CREATE TABLE public.majors (
    id uuid NOT NULL,
    code character varying(16) NOT NULL,
    name character varying(128) NOT NULL,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    logo character varying(255),
    website character varying(255),
    contact_email character varying(255),
    slogan character varying(255)
);



CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);



CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;



CREATE TABLE public.notifications (
    id uuid NOT NULL,
    user_id uuid NOT NULL,
    type character varying(255) NOT NULL,
    message text NOT NULL,
    is_read boolean DEFAULT false NOT NULL,
    related_schedule_id uuid,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT notifications_type_check CHECK (((type)::text = ANY ((ARRAY['jadwal_baru'::character varying, 'jadwal_ubah'::character varying, 'konflik'::character varying, 'info'::character varying])::text[])))
);



CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);



CREATE TABLE public.periods (
    id uuid NOT NULL,
    ordinal character varying(255) NOT NULL,
    start_time time without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    end_time time without time zone,
    is_teaching boolean
);



CREATE TABLE public.reports (
    id bigint NOT NULL,
    room_id uuid NOT NULL,
    date date NOT NULL,
    total_usage_hours numeric(5,2) DEFAULT '0'::numeric NOT NULL,
    total_idle_hours numeric(5,2) DEFAULT '0'::numeric NOT NULL,
    utilization_rate numeric(5,2) DEFAULT '0'::numeric NOT NULL,
    generated_at timestamp(0) without time zone NOT NULL
);



CREATE SEQUENCE public.reports_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



ALTER SEQUENCE public.reports_id_seq OWNED BY public.reports.id;



CREATE TABLE public.role_assignments (
    id uuid NOT NULL,
    major_id uuid NOT NULL,
    head_of_major_id uuid,
    program_coordinator_id uuid,
    terms_id uuid NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);



CREATE TABLE public.roles (
    id uuid NOT NULL,
    name character varying(50) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);



CREATE TABLE public.room_history (
    id uuid NOT NULL,
    room_id uuid NOT NULL,
    event_type character varying(255) NOT NULL,
    classes_id uuid NOT NULL,
    terms_id uuid NOT NULL,
    teacher_id uuid NOT NULL,
    user_id uuid NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);



CREATE TABLE public.rooms (
    id uuid NOT NULL,
    code character varying(32) NOT NULL,
    name character varying(128) NOT NULL,
    building_id character varying(64),
    floor integer,
    capacity integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    type character varying(255) NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    notes text,
    CONSTRAINT rooms_type_check CHECK (((type)::text = ANY ((ARRAY['kelas'::character varying, 'lab'::character varying, 'aula'::character varying, 'lainnya'::character varying])::text[])))
);



CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id uuid,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);



CREATE TABLE public.students (
    id uuid NOT NULL,
    nis character varying(32) NOT NULL,
    nisn character varying(32),
    users_id uuid CONSTRAINT students_user_id_not_null NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    avatar character varying(255)
);



CREATE TABLE public.subject_major_allowed (
    id uuid NOT NULL,
    subject_id uuid NOT NULL,
    major_id uuid NOT NULL,
    reason character varying(255),
    is_allowed boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);



CREATE TABLE public.subjects (
    id uuid NOT NULL,
    code character varying(32) NOT NULL,
    name character varying(128) NOT NULL,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    type character varying(255) NOT NULL,
    CONSTRAINT subjects_type_check CHECK (((type)::text = ANY ((ARRAY['teori'::character varying, 'praktikum'::character varying, 'lainnya'::character varying])::text[])))
);



CREATE TABLE public.teacher_subjects (
    id uuid NOT NULL,
    teacher_id uuid NOT NULL,
    subject_id uuid NOT NULL,
    started_at timestamp(0) without time zone NOT NULL,
    ended_at timestamp(0) without time zone NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);



CREATE TABLE public.teachers (
    id uuid NOT NULL,
    phone character varying(32),
    user_id uuid,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    code character varying(255) NOT NULL,
    avatar character varying(255)
);



CREATE TABLE public.terms (
    id uuid NOT NULL,
    tahun_ajaran character varying(64) CONSTRAINT terms_name_not_null NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    is_active boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    kind character varying(255) NOT NULL,
    CONSTRAINT terms_kind_check CHECK (((kind)::text = ANY ((ARRAY['ganjil'::character varying, 'genap'::character varying])::text[])))
);



CREATE TABLE public.timetable_entries (
    id uuid NOT NULL,
    template_id uuid NOT NULL,
    day_of_week character varying(255) NOT NULL,
    period_id uuid NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    teacher_subject_id uuid NOT NULL,
    room_history_id uuid,
    teacher_id uuid,
    room_id uuid,
    CONSTRAINT timetable_entries_day_of_week_check CHECK (((day_of_week)::text = ANY ((ARRAY['1'::character varying, '2'::character varying, '3'::character varying, '4'::character varying, '5'::character varying, '6'::character varying, '7'::character varying])::text[])))
);



CREATE TABLE public.timetable_templates (
    id uuid NOT NULL,
    class_id uuid NOT NULL,
    block_id uuid NOT NULL,
    version character varying(255) NOT NULL,
    is_active boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);



CREATE TABLE public.users (
    id uuid NOT NULL,
    name character varying(128) NOT NULL,
    email character varying(128) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password_hash character varying(255) NOT NULL,
    remember_token character varying(100),
    role_id uuid NOT NULL,
    last_login_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);















ALTER TABLE ONLY public.audit_logs
    ADD CONSTRAINT audit_logs_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.blocks
    ADD CONSTRAINT blocks_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.building
    ADD CONSTRAINT building_code_unique UNIQUE (code);



ALTER TABLE ONLY public.building
    ADD CONSTRAINT building_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);



ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);



ALTER TABLE ONLY public.classes
    ADD CONSTRAINT classes_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.classhistories
    ADD CONSTRAINT classhistories_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.company_relations
    ADD CONSTRAINT company_relations_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);



ALTER TABLE ONLY public.guardian_class_history
    ADD CONSTRAINT guardian_class_history_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.import_jobs
    ADD CONSTRAINT import_jobs_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.major_subject
    ADD CONSTRAINT major_subject_major_id_subject_id_unique UNIQUE (major_id, subject_id);



ALTER TABLE ONLY public.major_subject
    ADD CONSTRAINT major_subject_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.majors
    ADD CONSTRAINT majors_code_unique UNIQUE (code);



ALTER TABLE ONLY public.majors
    ADD CONSTRAINT majors_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.periods
    ADD CONSTRAINT periods_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.reports
    ADD CONSTRAINT reports_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.role_assignments
    ADD CONSTRAINT role_assignments_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.room_history
    ADD CONSTRAINT room_history_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.rooms
    ADD CONSTRAINT rooms_code_unique UNIQUE (code);



ALTER TABLE ONLY public.rooms
    ADD CONSTRAINT rooms_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_nis_unique UNIQUE (nis);



ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_user_id_unique UNIQUE (users_id);



ALTER TABLE ONLY public.subject_major_allowed
    ADD CONSTRAINT subject_major_allowed_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.subject_major_allowed
    ADD CONSTRAINT subject_major_allowed_unique UNIQUE (subject_id, major_id);



ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_code_unique UNIQUE (code);



ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.teacher_subjects
    ADD CONSTRAINT teacher_subjects_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.teachers
    ADD CONSTRAINT teachers_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.terms
    ADD CONSTRAINT terms_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.timetable_entries
    ADD CONSTRAINT timetable_entries_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.timetable_templates
    ADD CONSTRAINT timetable_templates_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.role_assignments
    ADD CONSTRAINT unique_head_per_term UNIQUE (head_of_major_id, terms_id);



ALTER TABLE ONLY public.role_assignments
    ADD CONSTRAINT unique_pc_per_term UNIQUE (program_coordinator_id, terms_id);



ALTER TABLE ONLY public.timetable_entries
    ADD CONSTRAINT unique_template_slot UNIQUE (template_id, day_of_week, period_id);



ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);



ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);



CREATE UNIQUE INDEX guardian_unique_active_per_class ON public.guardian_class_history USING btree (class_id) WHERE (ended_at IS NULL);



CREATE INDEX idx_guardian_class_history_block_id ON public.guardian_class_history USING btree (block_id);



CREATE INDEX idx_guardian_class_history_teacher_id ON public.guardian_class_history USING btree (teacher_id);



CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);



CREATE INDEX notifications_user_id_is_read_index ON public.notifications USING btree (user_id, is_read);



CREATE INDEX password_reset_tokens_email_index ON public.password_reset_tokens USING btree (email);



CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);



CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);



CREATE UNIQUE INDEX unique_active_guardian_per_teacher ON public.guardian_class_history USING btree (teacher_id) WHERE (ended_at IS NULL);



CREATE UNIQUE INDEX unique_timetable_room_slot ON public.timetable_entries USING btree (room_id, day_of_week, period_id);



CREATE UNIQUE INDEX unique_timetable_teacher_slot ON public.timetable_entries USING btree (teacher_id, day_of_week, period_id);



CREATE TRIGGER trg_check_guardian_role BEFORE INSERT OR UPDATE ON public.guardian_class_history FOR EACH ROW EXECUTE FUNCTION public.check_guardian_not_head_or_pc();



CREATE TRIGGER trg_check_role_assignments_once BEFORE INSERT OR UPDATE ON public.role_assignments FOR EACH ROW EXECUTE FUNCTION public.check_role_assignments_once_per_teacher();

ALTER TABLE ONLY public.blocks
    ADD CONSTRAINT blocks_terms_id_foreign FOREIGN KEY (terms_id) REFERENCES public.terms(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.classes
    ADD CONSTRAINT classes_major_id_foreign FOREIGN KEY (major_id) REFERENCES public.majors(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.classhistories
    ADD CONSTRAINT classhistories_block_id_foreign FOREIGN KEY (block_id) REFERENCES public.blocks(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.classhistories
    ADD CONSTRAINT classhistories_class_id_foreign FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.classhistories
    ADD CONSTRAINT classhistories_student_id_foreign FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.classhistories
    ADD CONSTRAINT classhistories_terms_id_foreign FOREIGN KEY (terms_id) REFERENCES public.terms(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.company_relations
    ADD CONSTRAINT company_relations_company_id_foreign FOREIGN KEY (company_id) REFERENCES public.companies(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.company_relations
    ADD CONSTRAINT company_relations_major_id_foreign FOREIGN KEY (major_id) REFERENCES public.majors(id) ON DELETE CASCADE;


ALTER TABLE ONLY public.guardian_class_history
    ADD CONSTRAINT guardian_class_history_class_id_foreign FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;


ALTER TABLE ONLY public.major_subject
    ADD CONSTRAINT major_subject_major_id_foreign FOREIGN KEY (major_id) REFERENCES public.majors(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.major_subject
    ADD CONSTRAINT major_subject_subject_id_foreign FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.reports
    ADD CONSTRAINT reports_room_id_foreign FOREIGN KEY (room_id) REFERENCES public.rooms(id) ON DELETE CASCADE;


ALTER TABLE ONLY public.role_assignments
    ADD CONSTRAINT role_assignments_major_id_foreign FOREIGN KEY (major_id) REFERENCES public.majors(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.role_assignments
    ADD CONSTRAINT role_assignments_terms_id_foreign FOREIGN KEY (terms_id) REFERENCES public.terms(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.room_history
    ADD CONSTRAINT room_history_classes_id_foreign FOREIGN KEY (classes_id) REFERENCES public.classes(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.room_history
    ADD CONSTRAINT room_history_room_id_foreign FOREIGN KEY (room_id) REFERENCES public.rooms(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.room_history
    ADD CONSTRAINT room_history_teacher_id_foreign FOREIGN KEY (teacher_id) REFERENCES public.teachers(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.room_history
    ADD CONSTRAINT room_history_terms_id_foreign FOREIGN KEY (terms_id) REFERENCES public.terms(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.room_history
    ADD CONSTRAINT room_history_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_user_id_foreign FOREIGN KEY (users_id) REFERENCES public.users(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.subject_major_allowed
    ADD CONSTRAINT subject_major_allowed_major_id_foreign FOREIGN KEY (major_id) REFERENCES public.majors(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.subject_major_allowed
    ADD CONSTRAINT subject_major_allowed_subject_id_foreign FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.teacher_subjects
    ADD CONSTRAINT teacher_subjects_subject_id_foreign FOREIGN KEY (subject_id) REFERENCES public.subjects(id);



ALTER TABLE ONLY public.teacher_subjects
    ADD CONSTRAINT teacher_subjects_teacher_id_foreign FOREIGN KEY (teacher_id) REFERENCES public.teachers(id);



ALTER TABLE ONLY public.timetable_entries
    ADD CONSTRAINT timetable_entries_period_id_foreign FOREIGN KEY (period_id) REFERENCES public.periods(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.timetable_entries
    ADD CONSTRAINT timetable_entries_room_history_id_foreign FOREIGN KEY (room_history_id) REFERENCES public.room_history(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.timetable_entries
    ADD CONSTRAINT timetable_entries_teacher_subject_id_foreign FOREIGN KEY (teacher_subject_id) REFERENCES public.teacher_subjects(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.timetable_entries
    ADD CONSTRAINT timetable_entries_template_id_foreign FOREIGN KEY (template_id) REFERENCES public.timetable_templates(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.timetable_templates
    ADD CONSTRAINT timetable_templates_block_id_foreign FOREIGN KEY (block_id) REFERENCES public.blocks(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.timetable_templates
    ADD CONSTRAINT timetable_templates_class_id_foreign FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;



ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;
