<?php
namespace Modules\Taxonomy\Contracts;
interface TermHierarchy {
  public function getEntity();
  public function getSubmissionData();
}