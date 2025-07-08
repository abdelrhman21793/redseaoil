<div>
    <x-alert />
    <form class="row g-3" method="POST" action="{{ route('structuresDesc.update', $structure->id) }}"
        style="width: 1400px;">
        @csrf
        @method('put')
        <label>Option Name</label>
        <select class="col-md-6" name="option_id" class="form-control" wire:model="selectedOption">
            @foreach ($options as $option)
                <option value="{{ $option->id }}" {{ $option->id == $structure->option_id ? 'selected' : '' }}>
                    {{ $option->name }}</option>
            @endforeach
        </select>
        <div class="card-body mx-auto">
            <div class="col-md-6" style="margin-bottom: 35px">
                <div style="margin-bottom: 10px">
                    <x-forms.input label="Structure Name" name="structureName" placeholder="Structure Name"
                        value="{{ $structure->name }}" />
                </div>
                @foreach ($structure->structure_descriptions as $index => $struct_desc)
                    @if ($struct_desc->user->type=='SUPER_ADMIN')
                    <div class="input-group mb-3" style="margin-left: 10px; display: flex; align-items: center;">
                        <x-forms.input type="hidden" value="{{ $struct_desc->id }}"
                            name="structuresDesUpdate[{{ $index }}][id]" />

                        <x-forms.input value="{{ $struct_desc->input }}"
                            name="structuresDesUpdate[{{ $index }}][input]" style="flex: 1;" />

                        <select name="structuresDesUpdate[{{ $index }}][type]" class="form-control" style="margin-left: 10px; flex: 1;">
                            @foreach ($types as $type)
                                <option value="{{ $type }}"
                                    {{ $type == $struct_desc->type ? 'selected' : '' }}>
                                    {{ $type }}</option>
                            @endforeach
                        </select>

                        @if (!empty($struct_desc->data))
                            @php
                                $data = json_decode($struct_desc->data, true);
                            @endphp
                            @foreach ($data as $dataIndex => $item)
                                <x-forms.input value="{{ $item }}"
                                    name="structuresDesUpdate[{{ $index }}][data][{{ $dataIndex }}]" />
                            @endforeach
                        @endif

                        <fieldset class="row" style="margin-left: 10px; flex: 1;">
                            <x-forms.radio
                                 :options="['Required' => 'Required', 'Optional' => 'Optional']"
                                 :checked="$struct_desc->is_require"
                                name="structuresDesUpdate[{{ $index }}][is_require]"
                                wire:model="structuresDesUpdate.{{ $index }}.is_require" />
                        </fieldset>

                        <fieldset class="row" style="margin-left: 10px; flex: 1;">
                            <x-forms.radio
                                 :options="['View' => 'View', 'None' => 'None']"
                                 :checked="$struct_desc->view"
                                name="structuresDesUpdate[{{ $index }}][view]"
                                wire:model="structuresDesUpdate.{{ $index }}.view" />
                        </fieldset>

                        <a href="{{ route('deleteStructDesc',$struct_desc->id) }}" class="btn btn-outline-danger"
                            style="padding: 12px; margin-left: 10px;">Delete</a>
                    </div>
                    @endif
                    <hr style="margin-bottom: 10px">
                @endforeach

                @foreach ($structuresDes as $index => $stuctureDesc)
                    <div class="input-group mb-3" style="margin-left: 10px; display: flex; align-items: center;">
                        <x-forms.input type="text" class="form-control"
                            name="structuresDes[{{ $index }}][input]"
                            wire='wire:model="structuresDes.{{ $index }}.input"' placeholder="Input" style="flex: 1;"/>

                        <select name="structuresDes[{{ $index }}][type]" style="margin-left: 10px; flex: 1;"
                            wire:model="structuresDes.{{ $index }}.type" class="form-control">
                            @foreach ($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>

                        <fieldset class="row" style="margin-left: 10px; flex: 1;">
                            <x-forms.radio
                            :options="['Required' => 'Required', 'Optional' => 'Optional']"
                                name="structuresDes[{{ $index }}][is_require]"
                                wire:model="structuresDes.{{ $index }}.is_require" />
                        </fieldset>

                        <fieldset class="row" style="margin-left: 10px; flex: 1;">
                            <x-forms.radio
                            :options="['View' => 'View', 'None' => 'None']"
                                name="structuresDes[{{ $index }}][view]"
                                wire:model="structuresDes.{{ $index }}.view" />
                        </fieldset>

                        <a href="#" class="btn btn-outline-danger"
                            wire:click.prevent="removeStruDesc({{ $index }})"
                            style="padding: 12px; margin-left: 10px;">Remove Desc</a>
                    </div>
                    <hr style="margin-bottom: 10px">
                @endforeach

                @foreach ($structuresDesMenu as $index => $structureDesMenu)
                    <div class="input-group mb-3" style="margin-left: 10px">
                        <x-forms.input type="hidden" name="structuresDesMenu[{{ $index }}][type]"
                            value="List" />
                        <div>
                            <div style="display: flex; align-items: center;">
                                <input type="text" wire:model="structuresDesMenu.{{ $index }}.name"
                                    name="structuresDesMenu[{{ $index }}][input]" placeholder="Input" />

                                <fieldset class="row" style="margin-left: 10px;">
                                    <x-forms.radio  :options="['Required' => 'Required', 'Optional' => 'Optional']"
                                        name="structuresDesMenu[{{ $index }}][is_require]"
                                        wire:model="structuresDesMenu.{{ $index }}.is_require" />
                                </fieldset>

                                <fieldset class="row" style="margin-left: 10px;">
                                    <x-forms.radio  :options="['View' => 'View', 'None' => 'None']"
                                        name="structuresDesMenu[{{ $index }}][view]"
                                        wire:model="structuresDesMenu.{{ $index }}.view" />
                                </fieldset>
                            </div>
                            <div>
                                @foreach ($structureDesMenu['data'] as $dataIndex => $data)
                                    <div class="form-group" style="margin: 5px">
                                        <input type="text"
                                            wire:model="structuresDesMenu.{{ $index }}.data.{{ $dataIndex }}"
                                            name="structuresDesMenu[{{ $index }}][data][{{ $dataIndex }}]"
                                            placeholder="Data" />
                                        <a href=""
                                            wire:click.prevent="removeData({{ $index }}, {{ $dataIndex }})"><span
                                                class="material-symbols-outlined">delete</span></a>
                                    </div>
                                @endforeach
                                <button class="btn btn-outline-secondary"
                                    wire:click.prevent="addData({{ $index }})">Add
                                    Data</button>
                                <button class="btn btn-outline-danger"
                                    wire:click.prevent="removeStruMenu({{ $index }})">Remove Menu</button>
                            </div>
                        </div>
                    </div>
                    <hr style="margin-bottom: 10px">
                @endforeach
            </div>
            <div class="btn-group">
                <button class="btn btn-sm btn-outline-secondary" wire:click.prevent="addStruDesc">+ Add
                    Description</button>
                <button class="btn btn-outline-primary" wire:click.prevent="addStruMenu">+Add In Menu</button>
                <button style="margin-left: 5px" type="submit" class="btn btn-outline-success">Save</button>
            </div>
        </div>
</div>
</form>
</div>
