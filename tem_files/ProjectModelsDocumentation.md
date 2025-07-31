# 🧠 توثيق نماذج وقواعد بيانات مشروع "موهبة"

## Users & Roles
### User
- يمثل جميع المستخدمين (مشرف، معلم، طالب، قائد...).
- العلاقات:
  - hasOne(Student | Supervisor | GiftedTeacher)
  - belongsToMany(Responsibility)

---

## الطلاب والمدارس
### Student
- يمثل الطالب الموهوب.
- العلاقات:
  - belongsTo(User)
  - hasMany(StudentAcademicRecord)
  - hasMany(ProgramRegistration)
  - hasMany(ProgramNomination)

### School
- المدرسة المرتبطة بمحافظة.
- العلاقات:
  - belongsTo(Province)
  - hasMany(Student)

### StudentAcademicRecord
- يمثل سجل الطالب في كل سنة دراسية.
- العلاقات:
  - belongsTo(Student)
  - belongsTo(AcademicYear)
  - belongsTo(School)

### AcademicYear
- العام الدراسي.
- العلاقات:
  - hasMany(StudentAcademicRecord)

---

## المشرفين والمهام
### Supervisor
- مشرف موهبة.
- العلاقات:
  - belongsTo(User)
  - belongsTo(AdministrativeRole)
  - hasMany(WeeklySupervisorPlan)
  - hasMany(VisitReport)
  - hasMany(ProgramReport)
  - belongsToMany(Province)
  - belongsToMany(Program)
  - hasMany(ProgramNomination)

### AdministrativeRole
- الدور الإداري للمشرف.
- العلاقات:
  - hasMany(Supervisor)

### WeeklySupervisorPlan
- خطة أسبوعية.
- العلاقات:
  - belongsTo(Supervisor)
  - hasMany(WeeklyPlanItem)

### WeeklyPlanItem
- عنصر داخل خطة.
- العلاقات:
  - belongsTo(WeeklySupervisorPlan)
  - hasOne(VisitReport)

### VisitReport
- تقرير الزيارة.
- العلاقات:
  - belongsTo(WeeklyPlanItem)
  - belongsTo(Supervisor)

---

## المعلمين والتخصصات
### GiftedTeacher
- معلم موهبة.
- العلاقات:
  - belongsTo(User)
  - belongsTo(Specialization)

### Specialization
- تخصص المعلمين.
- العلاقات:
  - hasMany(GiftedTeacher)

---

## المناطق والجهات
### Province
- محافظة تعليمية.
- العلاقات:
  - belongsTo(EducationRegion)
  - hasMany(School)
  - belongsToMany(Supervisor)

### EducationRegion
- منطقة تعليمية.
- العلاقات:
  - hasMany(Province)

---

## البرامج
### Program
- برنامج موهبة تدريبي.
- العلاقات:
  - belongsTo(Supervisor as Manager)
  - belongsTo(Province)
  - hasMany(ProgramRegistration)
  - hasMany(ProgramReport)
  - hasMany(ProgramNomination)
  - belongsToMany(Supervisor)

### ProgramRegistration
- تسجيل الطالب.
- العلاقات:
  - belongsTo(Student)
  - belongsTo(Program)

### ProgramReport
- تقرير تنفيذ البرنامج.
- العلاقات:
  - belongsTo(Program)
  - belongsTo(Supervisor)

### ProgramNomination
- ترشيح الطلاب.
- العلاقات:
  - belongsTo(Student)
  - belongsTo(Program)
  - morphTo(Nominator: Supervisor | GiftedTeacher)

---

## المهام الأخرى
### Responsibility
- المهام المخصصة للمستخدم.
- العلاقات:
  - belongsToMany(User)

---

## Pivot Models
### ProgramSupervisor
- بين Program و Supervisor

### ProvinceSupervisor
- بين Province و Supervisor

---

## ✅ ملاحظات تحسين
- استخدم enum constants داخل models:
  - stage (kindergarten, primary...)
  - grade (G1, G2, ...)
  - status (مستخدم في البرامج)
- استخدم Pivot Models لإدارة many-to-many بمرونة.