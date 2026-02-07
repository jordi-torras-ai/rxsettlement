@php
    $only = $only ?? null;
    $rendered = false;
    $shouldRender = fn (string $id): bool => is_null($only) || $only === $id;
@endphp

@if ($shouldRender('left-navigation'))
    @php $rendered = true; @endphp
    <section data-instructions-section="left-navigation">
        <h3 id="left-navigation">Left Navigation</h3>
        <div class="not-prose flex flex-col gap-4 md:flex-row md:items-start md:gap-6">
            <div class="flex-shrink-0">
                <img src="{{ asset('images/left_menu.png') }}" alt="" style="max-width: none; width: auto; height: auto;" />
            </div>
            <div class="flex-1">
                <p class="text-base text-gray-700 dark:text-gray-200">The navigation bar on the left, is designed to sequentially take you through the process, as <strong>illustrated</strong> alongside. However, you can independently navigate the various areas of the input process.</p>
            </div>
        </div>
        <div class="not-prose flex flex-col gap-4 md:flex-row md:items-start md:gap-6">
            <div class="flex-1">
                <p class="text-base text-gray-700 dark:text-gray-200">If you get stuck, each section provides an <strong>"Instructions"</strong> button, in the right upper hand corner. Additionally, there is a <strong>"Glossary"</strong> of terms available in the navigation, should questions arise during the intake process. During the initial intake meeting, you will also be provided a <strong>"Key Contact"</strong> list of representatives assigned to your company.</p>
            </div>
            <div class="flex-shrink-0">
                <img src="{{ asset('images/instructions.png') }}" alt="" style="max-width: none; width: auto; height: auto;" />
            </div>
        </div>
    </section>
@endif

@if ($shouldRender('employers'))
    @php $rendered = true; @endphp
    <section data-instructions-section="employers">
        <h3 id="employers">Employers</h3>
        <p>As a new employer/plan sponsor, this section provides the details of your organization. Pay close attention to the assignment of company representatives and their contact information:</p>

        <ul>
            <li><strong>Authorized Primary Contact</strong> - this is the person authorized by your company to have oversight of the intake data being accurate.</li>
            <li><strong>Billing Contact</strong> - this is the individual who is responsible for vendor payments.</li>
        </ul>

        <p>Day-to-day contact and escalation contact information will be obtained in the "Intake" section of the process.</p>
        <p><img src="{{ asset('images/employer.png') }}" alt="" /></p>
    </section>
@endif

@if ($shouldRender('intake'))
    @php $rendered = true; @endphp
    <section data-instructions-section="intake">
        <h3 id="intake">Intake</h3>
        <p>Recognizing all organizations may be different. A section has been designed to have contacts being assigning the necessary data for the intake.  If these individuals are the same person, just note ‘same’ in this section.  If they are different, provide the contact information.</p>
        <p><img src="{{ asset('images/intake.png') }}" alt="" /></p>
    </section>
@endif

@if ($shouldRender('vendor-coverages'))
    @php $rendered = true; @endphp
    <section data-instructions-section="vendor-coverages">
        <h3 id="vendor-coverages">Vendor Coverages</h3>
        <p>Vendor information is necessary to understand the Plan offerings to plan participants. Our company provides the option of a representative of our organization to contact vendor’s directly to obtain missing information.  This is an option, and determined by the Employer/Plan Sponsor. During the initial meeting, our representative will determine the appropriate use of this information.</p>
        <p>At minimum, the system will be capturing three (3) years of Plan data.  Therefore, this information will be requested for the current year, and for each of the historical years being provided.</p>
        <p><img src="{{ asset('images/vendor_coverage.png') }}" alt="" /></p>
    </section>
@endif

@if ($shouldRender('plan-design-year'))
    @php $rendered = true; @endphp
    <section data-instructions-section="plan-design-year">
        <h3 id="plan-design-year">Plan Design Year</h3>
        <p>Each of the three (3) years of Plan offerings must be completed.  This information is critical, as ‘overcharging’ is determined by the ‘unit cost of care’ by procedure, based on the network being used.  This allows our company to benchmark the data appropriately for your Plan.</p>
        <p>For each Plan year being submitted, ‘click’ the ‘new plan design year’ button to complete the information.</p>
        <p>An example entry is provided as a guideline.</p>
        <p><img src="{{ asset('images/plan_design_years.png') }}" alt="" /></p>
    </section>
@endif

@if ($shouldRender('financial-impact'))
    @php $rendered = true; @endphp
    <section data-instructions-section="financial-impact">
        <h3 id="financial-impact">Financial Impact</h3>
        <p>In completing the analysis, the use of these data elements is necessary to define the injured party, and the amount of the injury to the Employer/Plan Sponsor and to the plan participant. This ensures reporting to the appropriate parties is accurate.</p>

        <ul>
            <li><strong>Budget Premium - Equivalent Funding Monthly Rates</strong></li>
        </ul>
        <p>The budget premium is the equivalent to the monthly rates established for the cost of the Plan.</p>

        <ul>
            <li><strong>Employee Monthly Contributions</strong></li>
        </ul>
        <p>The employee monthly contributions identify the impact at the plan participant level.</p>

        <ul>
            <li><strong>PEPM Admin Fee Group</strong></li>
        </ul>
        <p>The per employee/per month (PEPM) administrative fee identifies the fixed costs of the premium being paid for administrative support of the plan.</p>
        <p><img src="{{ asset('images/financial_impact.png') }}" alt="" /></p>
    </section>
@endif

@if ($shouldRender('document-types'))
    @php $rendered = true; @endphp
    <section data-instructions-section="document-types">
        <h3 id="document-types">Document Types</h3>
        <p>To complete the comprehensive analysis the various document types must be provided to complete the queries required.  This is a checklist of the required documents which need to be uploaded into the system.</p>
        <p>Governing plan documents ensure algorithms are applied appropriately to the ‘Financial Impact’ reporting and analysis.</p>

        <ul>
            <li><strong>Census Template</strong></li>
        </ul>
        <p>A census template is provided, with instructions and an example for completion.  The census template does not have to be populated.  However, all data elements must be present in the census file uploaded to the system.</p>

        <ul>
            <li><strong>Governing Documents</strong></li>
        </ul>
        <p>The documents requested are used to map appropriate plan designs to plan participants. The governing documents required are illustrated below.  From time to time the governing documents list may change based upon legislative changes, or internal best practices.  Your company will be notified if additional documents are required.</p>
        <p><img src="{{ asset('images/document_types.png') }}" alt="" /></p>
    </section>
@endif

@if ($shouldRender('documents'))
    @php $rendered = true; @endphp
    <section data-instructions-section="documents">
        <h3 id="documents">Documents</h3>
        <p>Once documents are compiled and ready for upload, this is the area to upload ‘new documents.’  Based on the ‘Plan Design Year’ data entry, this section will be pre-populated for completion by the Employer/Plan Sponsor.  If a document does not appear in this section, it is an indication that the necessary information has not been entered into the ‘Plan Design Year.’</p>
        <p><img src="{{ asset('images/documents.png') }}" alt="" /></p>
    </section>
@endif

@if ($shouldRender('glossary'))
    @php $rendered = true; @endphp
    <section data-instructions-section="glossary">
        <h3 id="glossary">Glossary</h3>
        <p>The glossary is provided to help you understand important concepts and terms used throughout the intake process.</p>
    </section>
@endif

@if ($shouldRender('submission'))
    @php $rendered = true; @endphp
    <section data-instructions-section="submission">
        <h3 id="submission">Submission</h3>
        <p>Upon completion of each section, confirm all ‘documents’ required have been uploaded.  If documents are not available, provide an explanation.</p>
        <p>As part of the submission process, the authorized company representative must complete the acknowledgement of the terms of use.</p>
        <p>You are now ready for submission.</p>
        <p>When 1BeneCare receives your submission, a 1BeneCare  representative will contact you if there is missing information, or clarification is required.</p>
    </section>
@endif

@if ($shouldRender('changes-to-submission'))
    @php $rendered = true; @endphp
    <section data-instructions-section="changes-to-submission">
        <h3 id="changes-to-submission">Changes to the Submission</h3>
        <p>During the term of this engagement, if there are changes in your organization; plan designs; plan participant contributions; acquisition etc. a new submission should be completed.</p>
    </section>
@endif

@if ($only && (! $rendered))
    <div class="text-sm text-gray-600 dark:text-gray-300">
        Instructions are not available for this section.
    </div>
@endif
