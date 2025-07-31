# 📘 توثيق ملخص للجداول والعلاقات

## 🗂️ `academic_years`

- **الحقول**: `active, end_date, name, start_date`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `-`

## 🗂️ `administrative_roles`

- **الحقول**: `active, code, description, name`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `-`

## 🗂️ `education_regions`

- **الحقول**: `name`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `-`

## 🗂️ `gifted_teachers`

- **الحقول**: `academic_qualification, assigned_at, experience_years, notes, school_id, specialization_id, user_id`
- **الجداول المرتبطة**: `users`
- **أنواع العلاقات**: `FK`

## 🗂️ `program_nominations`

- **الحقول**: `nominated_by, note, program_id, student_id`
- **الجداول المرتبطة**: `users`
- **أنواع العلاقات**: `FK`

## 🗂️ `program_registrations`

- **الحقول**: `certificate_url, evaluation, program_id, registered_at, student_id`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `FK`

## 🗂️ `program_reports`

- **الحقول**: `achievements, attendees_count, evaluation, program_id, report_date, summary`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `FK`

## 🗂️ `program_supervisors`

- **الحقول**: `assigned_at, is_lead, program_id, supervisor_id`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `FK`

## 🗂️ `programs`

- **الحقول**: `allow_self_registration, description, end_date, manager_id, province_id, start_date, status, title`
- **الجداول المرتبطة**: `supervisors`
- **أنواع العلاقات**: `FK`

## 🗂️ `province_supervisor`

- **الحقول**: `active, notes, province_id, supervisor_id`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `FK`

## 🗂️ `provinces`

- **الحقول**: `education_region_id, name`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `FK`

## 🗂️ `responsibilities`

- **الحقول**: `active, code, description, scope_id, scope_type, title`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `-`

## 🗂️ `responsibility_user`

- **الحقول**: `responsibility_id, user_id`
- **الجداول المرتبطة**: `responsibilities, users`
- **أنواع العلاقات**: `FK`

## 🗂️ `schools`

- **الحقول**: `gifted_teacher_user_id, ministry_code, name, principal_user_id, province_id, status`
- **الجداول المرتبطة**: `users`
- **أنواع العلاقات**: `FK`

## 🗂️ `specializations`

- **الحقول**: `description, name`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `-`

## 🗂️ `student_academic_records`

- **الحقول**: `academic_year_id, note, promoted, school_id, student_id, talent_score, transferred`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `FK`

## 🗂️ `students`

- **الحقول**: `birth_date, note, school_id, talent_score_1, talent_score_2, talent_score_3, user_id, year__score_1, year__score_2, year__score_3`
- **الجداول المرتبطة**: `users`
- **أنواع العلاقات**: `FK`

## 🗂️ `supervisors`

- **الحقول**: `administrative_role_id, user_id`
- **الجداول المرتبطة**: `administrative_roles, users`
- **أنواع العلاقات**: `FK`

## 🗂️ `users`

- **الحقول**: `email, email_verified_at, name, national_id, password, phone, status`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `-`

## 🗂️ `visit_reports`

- **الحقول**: `recommendations, summary, visited_at, weekly_plan_item_id`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `FK`

## 🗂️ `weekly_plan_items`

- **الحقول**: `activities, date, location, notes, objectives, title, weekly_supervisor_plan_id`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `FK`

## 🗂️ `weekly_supervisor_plans`

- **الحقول**: `supervisor_id, week_end, week_start`
- **الجداول المرتبطة**: `-`
- **أنواع العلاقات**: `FK`
