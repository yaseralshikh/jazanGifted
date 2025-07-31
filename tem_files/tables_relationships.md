# 📘 توثيق الجداول والعلاقات في قاعدة البيانات

## 🗂️ جدول: `users`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `name` | - | - |
| `email` | - | - |
| `phone` | - | - |
| `national_id` | - | - |
| `email_verified_at` | - | - |
| `password` | - | - |
| `status` | - | - |


## 🗂️ جدول: `administrative_roles`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `name` | - | - |
| `code` | - | - |
| `description` | - | - |
| `active` | - | - |


## 🗂️ جدول: `education_regions`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `name` | - | - |


## 🗂️ جدول: `provinces`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `name` | - | - |
| `education_region_id` | FK | - |


## 🗂️ جدول: `schools`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `name` | - | - |
| `province_id` | FK | - |
| `ministry_code` | - | - |
| `principal_user_id` | FK | users |
| `gifted_teacher_user_id` | FK | users |
| `status` | - | - |


## 🗂️ جدول: `students`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `birth_date` | - | - |
| `school_id` | FK | - |
| `user_id` | FK | users |
| `talent_score_1` | - | - |
| `talent_score_2` | - | - |
| `talent_score_3` | - | - |
| `year__score_1` | - | - |
| `year__score_2` | - | - |
| `year__score_3` | - | - |
| `note` | - | - |


## 🗂️ جدول: `supervisors`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `user_id` | FK | users |
| `administrative_role_id` | FK | administrative_roles |


## 🗂️ جدول: `programs`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `title` | - | - |
| `start_date` | - | - |
| `end_date` | - | - |
| `description` | - | - |
| `province_id` | FK | - |
| `manager_id` | FK | supervisors |
| `allow_self_registration` | - | - |
| `status` | - | - |


## 🗂️ جدول: `specializations`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `name` | - | - |
| `description` | - | - |


## 🗂️ جدول: `gifted_teachers`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `user_id` | FK | users |
| `school_id` | FK | - |
| `specialization_id` | FK | - |
| `academic_qualification` | - | - |
| `experience_years` | - | - |
| `assigned_at` | - | - |
| `notes` | - | - |


## 🗂️ جدول: `program_registrations`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `student_id` | FK | - |
| `program_id` | FK | - |
| `registered_at` | - | - |
| `evaluation` | - | - |
| `certificate_url` | - | - |


## 🗂️ جدول: `province_supervisor`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `province_id` | FK | - |
| `supervisor_id` | FK | - |
| `active` | - | - |
| `notes` | - | - |


## 🗂️ جدول: `program_supervisors`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `program_id` | FK | - |
| `supervisor_id` | FK | - |
| `is_lead` | - | - |
| `assigned_at` | - | - |


## 🗂️ جدول: `responsibilities`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `title` | - | - |
| `code` | - | - |
| `description` | - | - |
| `active` | - | - |
| `scope_type` | - | - |
| `scope_id` | - | - |


## 🗂️ جدول: `responsibility_user`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `responsibility_id` | FK | responsibilities |
| `user_id` | FK | users |


## 🗂️ جدول: `academic_years`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `name` | - | - |
| `start_date` | - | - |
| `end_date` | - | - |
| `active` | - | - |


## 🗂️ جدول: `weekly_supervisor_plans`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `supervisor_id` | FK | - |
| `week_start` | - | - |
| `week_end` | - | - |


## 🗂️ جدول: `weekly_plan_items`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `weekly_supervisor_plan_id` | FK | - |
| `date` | - | - |
| `location` | - | - |
| `title` | - | - |
| `objectives` | - | - |
| `activities` | - | - |
| `notes` | - | - |


## 🗂️ جدول: `visit_reports`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `weekly_plan_item_id` | FK | - |
| `visited_at` | - | - |
| `summary` | - | - |
| `recommendations` | - | - |


## 🗂️ جدول: `program_reports`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `program_id` | FK | - |
| `report_date` | - | - |
| `summary` | - | - |
| `attendees_count` | - | - |
| `achievements` | - | - |
| `evaluation` | - | - |


## 🗂️ جدول: `program_nominations`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `program_id` | FK | - |
| `student_id` | FK | - |
| `nominated_by` | FK | users |
| `note` | - | - |


## 🗂️ جدول: `student_academic_records`

| اسم الحقل | نوع العلاقة | الجدول المرتبط |
|------------|----------------|------------------|
| `student_id` | FK | - |
| `academic_year_id` | FK | - |
| `school_id` | FK | - |
| `talent_score` | - | - |
| `promoted` | - | - |
| `transferred` | - | - |
| `note` | - | - |