@extends('layouts.master')

@section('mainContainer')
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.menu.condiciones') !!}</b></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-offset-2 col-sm-8 col-md-offset-2 col-md-8">
                        <p>The data and software displayed in the NAPROC-13 database are freely available with the
                            following conditions:</p>
                        <p>
                        <ul style="margin-left: 2em">
                            <li>No license is needed for academic, nonprofit, and personal use.</li>
                            <li>NAPROC-13 is the result of a large collaborative effort among several individuals at the
                                University of Salamanca and at research institutions around the world. In order to
                                acknowledge the scientists and engineers who have contributed to the USAL NAPROC-13
                                database and its data, and the organizations who have made this project possible through
                                their generous funding, please cite the following reference:
                            </li>
                        </ul>
                        </p>
                        <p>José Luis López-Pérez, Roberto Therón, Esther del Olmo, David Díaz: NAPROC-13: a database for
                            the dereplication of natural product mixtures in bioassay-guided protocols. Bioinformatics
                            23(23): 3256-3257 (2007)</p>
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection