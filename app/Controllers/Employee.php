<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;


class Employee extends BaseController
{
    /* ================================================================
       EXISTING CRUD METHODS
       ================================================================ */
    public function index(): string
    {
        $model = new EmployeeModel();
        $data['employees'] = $model->findAll();
        return view('employee/index', $data);
    }

    public function create()
    {
        return view('employee/create');
    }

    public function store()
    {
        $model = new EmployeeModel();
        $data  = $this->request->getPost();
        $file  = $this->request->getFile('Photo');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName       = $file->getRandomName();
            $file->move('uploads/', $newName);
            $data['Photo'] = $newName;
        }

        $model->save($data);
        return redirect()->to('/employee');
    }

    public function show($id)
    {
        $model          = new EmployeeModel();
        $data['employee'] = $model->find($id);
        return view('employee/show', $data);
    }

    public function edit($id)
    {
        $model          = new EmployeeModel();
        $data['employee'] = $model->find($id);

        if (!$data['employee']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Employee not found");
        }
        return view('employee/edit', $data);
    }

    public function update($id)
    {
        $model    = new EmployeeModel();
        $employee = $model->find($id);
        $data     = $this->request->getPost();
        $photo    = $this->request->getFile('Photo');

        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName       = $photo->getRandomName();
            $photo->move('uploads/', $newName);
            $data['Photo'] = $newName;

            if (!empty($employee['Photo']) && file_exists('uploads/' . $employee['Photo'])) {
                unlink('uploads/' . $employee['Photo']);
            }
        } else {
            $data['Photo'] = $employee['Photo'];
        }

        $model->update($id, $data);
        return redirect()->to('/employee')->with('success', 'Employee updated successfully!');
    }

    public function delete($id)
    {
        $model = new EmployeeModel();
        if ($model->find($id)) {
            $model->delete($id);
            return redirect()->to('/employee')->with('success', 'Employee deleted successfully.');
        }
        return redirect()->to('/employee')->with('error', 'Employee not found.');
    }

    public function view($id)
    {
        $model    = new EmployeeModel();
        $employee = $model->find($id);
        if (!$employee) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Employee not found.");
        }
        return view('employee/view', ['employee' => $employee]);
    }

    /* ================================================================
       DIRECTORY & EXPORT
       ================================================================ */
    public function directory()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('employees')
            ->select('*')
            ->orderBy('last_name')
            ->orderBy('first_name');

        $data = [
            'provinces'     => $db->table('employees')->select('province')->distinct()->orderBy('province')->get()->getResultArray(),
            'municipalities'=> $db->table('employees')->select('municipality')->distinct()->orderBy('municipality')->get()->getResultArray(),
            'positions'     => $db->table('employees')->select('plantilla_position')->distinct()->orderBy('plantilla_position')->get()->getResultArray(),
            'designations'  => $db->table('employees')->select('designation')->distinct()->orderBy('designation')->get()->getResultArray(),
        ];

        foreach (['province', 'municipality', 'plantilla_position', 'designation'] as $key) {
            if ($this->request->getGet($key)) {
                $builder->where($key, $this->request->getGet($key));
            }
        }

        $data['employees'] = $builder->get()->getResultArray();
        return view('employee/directory', $data);
    }

    public function export()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('employees')
            ->select('id, first_name, middle_name, last_name, province, municipality, designation, plantilla_position, email, contact_no')
            ->orderBy('last_name')
            ->orderBy('first_name');

        foreach (['province', 'municipality', 'plantilla_position', 'designation'] as $key) {
            if ($this->request->getGet($key)) {
                $builder->where($key, $this->request->getGet($key));
            }
        }

        $rows = $builder->get()->getResultArray();
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $headers     = ['ID','First','Middle','Last','Province','Municipality','Designation','Position','Email','Contact'];

        $sheet->fromArray($headers, null, 'A1');
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        $row = 2;
        foreach ($rows as $emp) {
            $sheet->fromArray(array_values($emp), null, 'A' . $row);
            $row++;
        }

        foreach (range('A','J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Employee_Directory_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }

    /* ================================================================
   IMPORT METHODS
   ================================================================ */
    public function importForm()
    {
        return view('employee/import_form'); // This will be the new form view
    }


   public function import()
    {
        $file = $this->request->getFile('excel_file');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Invalid file upload.');
        }

        // Move uploaded file to writable/uploads
        $newName  = $file->getRandomName();
        $filePath = WRITEPATH . 'uploads/' . $newName;
        $file->move(WRITEPATH . 'uploads', $newName);

        // Detect file type
        $extension = strtolower($file->getClientExtension());
        if ($extension === 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } elseif ($extension === 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } elseif ($extension === 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            return redirect()->back()->with('error', 'Unsupported file format.');
        }

        try {
            $spreadsheet = $reader->load($filePath);
            $sheetData   = $spreadsheet->getActiveSheet()->toArray();

            $employeeModel = new \App\Models\EmployeeModel();
            $insertedCount = 0;

            /**
             * Expected column order in Excel:
             * last_name, first_name, ext, middle_name, municipality, province, region,
             * plantilla_position, salary_grade, designation, gender, age, birthdate,
             * civil_status, is_real_estate_appraiser, license_no, date_of_license_registration,
             * date_of_license_expiration, email, contact_no, retirement_year, ipcr_rating,
             * date_of_last_laoe_conducted, Photo
             */

            for ($i = 1; $i < count($sheetData); $i++) { // skip header row
                $row = $sheetData[$i];

                // Map Excel columns to DB fields
                $data = [
                    'last_name'                  => $row[0]  ?? null,
                    'first_name'                 => $row[1]  ?? null,
                    'ext'                        => $row[2]  ?? null,
                    'middle_name'                => $row[3]  ?? null,
                    'municipality'               => $row[4]  ?? null,
                    'province'                   => $row[5]  ?? null,
                    'region'                     => $row[6]  ?? null,
                    'plantilla_position'         => $row[7]  ?? null,
                    'salary_grade'               => $row[8]  ?? null,
                    'designation'                => $row[9]  ?? null,
                    'gender'                     => $row[10] ?? null,
                    'age'                        => $row[11] ?? null,
                    'birthdate'                  => $row[12] ?? null,
                    'civil_status'               => $row[13] ?? null,
                    'is_real_estate_appraiser'   => $row[14] ?? null,
                    'license_no'                 => $row[15] ?? null,
                    'date_of_license_registration'=> $row[16] ?? null,
                    'date_of_license_expiration' => $row[17] ?? null,
                    'email'                      => $row[18] ?? null,
                    'contact_no'                 => $row[19] ?? null,
                    'retirement_year'            => $row[20] ?? null,
                    'ipcr_rating'                => $row[21] ?? null,
                    'date_of_last_laoe_conducted'=> $row[22] ?? null,
                    'Photo'                      => $row[23] ?? null
                ];

                // Only insert if at least first and last name exist
                if (!empty($data['first_name']) && !empty($data['last_name'])) {
                    $employeeModel->insert($data);
                    $insertedCount++;
                }
            }

            return redirect()->back()->with('success', "$insertedCount employees imported successfully.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error reading file: ' . $e->getMessage());
        }
    }

}
