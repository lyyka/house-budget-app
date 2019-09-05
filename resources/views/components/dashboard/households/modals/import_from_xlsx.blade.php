<div class="modal fade" id="importDataFromXlsxModal" tabindex="-1" role="dialog" aria-labelledby="importDataFromXlsxModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="importDataFromXlsxModalTitle">
                Import Data From Excel
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @if (Auth::user()->hasVerifiedEmail())
                <p>You can import all expenses to our database by uploading excel document containing those expenses</p>
                <img class="img-fluid" src="{{ asset('storage/excel_import/import_template_tutorial.gif') }}" alt="Import table preview" />
                <label class="text-muted">Template preview</label>
                <p>
                    Make sure to use <a class="text-info" download href="{{ asset('storage/excel_import/import_template.xlsx') }}">our template excel document</a> so all your expanses get imported correctly.<br />
                    If you happen to already have an excel file, please modify it so the first three columns become <span class="text-success">Name</span>, <span class="text-success">Amount</span>, <span class="text-success">Category</span>.
                </p>
                <hr />
                When it's all done, you can upload your file
                <br />
                <form action="/excel/import" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-btn-wrapper">
                        <button type="button" class="py-1 px-0 border-0 bg-transparent text-success cursor-pointer"><i class="fas fa-file-upload"></i> Upload a .XLSX file</button>
                        <input type="file" name="excel_import_table" id="excel_import_table" class="cursor-pointer" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                    </div>
                    <div id="excel_import_show_when_selected" style = "display: none;">
                        <p class="mb-1" id="import_file_name"></p>
                        <button type="submit" class="py-1 px-3 border bg-success text-white rounded shadow-sm cursor-pointer">Import from this file</button>
                    </div>
                </form>
            @else
                <p class="text-center text-muted">
                    Please verify your email address to be able to import expenses from Excel spreadsheet
                </p>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="px-3 py-1 bg-secondary text-white rounded shadow-sm border" data-dismiss="modal">Close</button>
            <a download href = "{{ asset('storage/excel_import/import_template.xlsx') }}" class="px-3 py-1 bg-info text-white rounded shadow-sm border"><i class="fas fa-file-download"></i> Download Template</a>
        </div>
    </div>
    </div>
</div>